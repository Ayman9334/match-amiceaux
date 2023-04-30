$(document).ready(function (){
	 $(document).on('click', 'span[wact],a[wact], div[wact], input[wact], i[wact]', function(){
		ajax_prepare($(this));
	});
	 $(document).off('click', '.delClass').on('click', '.delClass', function(){
		 addGenericConfirmAction($(this), "Vous êtes sur le point de supprimer cet élément.<br>Confirmez-vous cette action ?");
	 });
	 
	 refreshSpecialComps();
});

/**
 * @param source
 */
function ajax_prepare(source){
	if(source.attr("disabled")){
		return;
	}
	// Prevent double click
	source.attr("disabled", "disabled");
	
	var formObj = source.closest("form");
	if(formObj.length == 0){
		formObj = $("#data_form");
	}
	var formId = formObj.attr("id");
	
	// Edit
	var controller = source.attr("wact");
	
	if(source.attr("params") != null){
		controller = controller + "&"+source.attr("params");
	}
	
	ajax_submit(formId, controller, source);	 
}

/**
 * 
 */
function ajax_submit(formId, controller, source){
	// Errase all labels
	$(".error_label").each(function(){
		$(this).css("display", "none");
		$(this).text("");
	});
	
	// Show loading animation
	showSpinner();
	
	// Pour fonctionner le upload
	var formData = (formId ? new FormData($("#"+formId)[0]) : null);
    //
    $.ajax({
        beforeSend: function(data) {
        },
        url: "page-"+controller,
        data: formData,//(formId ? $("#"+formId).serialize() : null),
        type: "POST",
        cache: false,
        //dataType: 'text',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        error: function(data) {
            hideSpinner();
            source.removeAttr("disabled");
        },
        success: function(data) {
        	source.removeAttr("disabled");
//        	alert(data);
        	// Cas message succes simple
        	if(data.startsWith('SUCCES')){// ------------------------------------------
        		hideSpinner();
        		
        		if($("#close_modal").length > 0){
					$("#close_modal").trigger("click");
				}
        		var messageTxt = "La mise &agrave; jour est effectu&eacute;e avec succ&egrave;s.";
        		if(data.indexOf(":") != -1){
        			messageTxt = data.substring(data.indexOf(":")+1, data.length); 
        		}
        		if(source.attr("eval")){
        			eval(source.attr("eval"));
        		}
        		
        		alertify.success(messageTxt);
        		return;
        	}// ---------------------------------------------------------------
        	
        	data = $.trim(data);
        	//
            if(data != ''){
        		if(data.indexOf("\":\"") != -1 && data.indexOf(">") == -1){
	        		var jsonResponse = jQuery.parseJSON(data);
	        		var firstErr = null;
	        		for (var key in jsonResponse) {
	        			if(key == 'popoMsg'){
	        		        alertify.set({
	        		            labels: {
	        		              ok: "Fermer"
	        		            },
	        		            delay: 5000,
	        		            buttonReverse: false,
	        		            buttonFocus: "ok"
	        		          });
	        				alertify.alert(jsonResponse[key]);
	        			} else{
		        			if (jsonResponse.hasOwnProperty(key)) {
		        				
		        				if(firstErr == null){
		        					firstErr = $("#"+key);
		        				}
		        				
		        				$('<label class="error_label">'+jsonResponse[key]+'</label>').insertAfter("#"+key);
		        			}
	        			}
	        		}
	        		
	        		if(firstErr != null){
	        			firstErr.focus();
	        		}
	        		
	        		alertify.error("Des erreurs de saisie ont &eacute;t&eacute; trouv&eacute;es.<br> Veuillez corriger le formulaire.");
        		} else if(data.indexOf('forward:') != -1){
        			var url = data.substring(data.indexOf(":")+1, data.length);
        			if(url == 'refresh'){
        				window.location.reload();
        			} else {
        				window.location =url;
        			}
        		} else {
        			// Close
        			if(source.attr("closeModal")){
        				if($("#close_modal").length > 0){
        					$("#close_modal").trigger("click");
        				}
        			}
        			
        			if(source.attr("targetDiv")){
        				$('#'+source.attr("targetDiv")).html(data);
        			} else{
        				$('.body-wrapper').html(data);	
        			}
        		}
        	}
        	// Hide sinner
            hideSpinner();
            refreshSpecialComps();
        }
    });	
}

/**
 * @param targetUrl
 * @param targetDiv
 */
function callCtrl(targetUrl, targetDiv, formId, closeModal){
	showSpinner();
	
	var formData = null;
	if(formId){
		formData = new FormData($("#"+formId)[0]);
	}
	
	$.ajax({
        beforeSend: function(data) {
        },
        url: targetUrl,
        data: formData,
        type: "POST",
        cache: false,
        //dataType: 'text',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        error: function(data) {
            hideSpinner();
        },
        success: function(data) {
        	hideSpinner();
        	
    		if(data.indexOf("\":\"") != -1 && data.indexOf(">") == -1){
    			var jsonResponse = jQuery.parseJSON(data);	
        		for (var key in jsonResponse) {
        			if(key == 'popoMsg'){
        		        alertify.set({
        		            labels: {
        		              ok: "Fermer"
        		            },
        		            delay: 5000,
        		            buttonReverse: false,
        		            buttonFocus: "ok"
        		          });
        				alertify.alert(jsonResponse[key]);
        			} else{
        				if (jsonResponse.hasOwnProperty(key)) {
        					$('<label class="error_label">'+jsonResponse[key]+'</label>').insertAfter("#"+key);
	        			}
        			}
        		}
        		alertify.error("Des erreurs de saisie ont &eacute;t&eacute; trouv&eacute;es.<br> Veuillez corriger le formulaire.");
        		return;
    		}

        	if(targetDiv){
        		if($("#"+targetDiv).prop('nodeName') && $("#"+targetDiv).prop('nodeName').toLowerCase() != 'div'){
        			$("#"+targetDiv).val(data);
        		} else{
        			$("#"+targetDiv).html(data);
        		}
        	}
    		 
    		 if(closeModal && $("#close_modal").length > 0){
 				$("#close_modal").trigger("click");
 			}
        }
	});
}

function refreshSpecialComps(){
	$("select[noedit!='true']").select2({
		language: "fr",
		placeholder: "",
		allowClear: true
	});
	 $('input[date="1"]').mask('00/00/0000');
	 $('input[hm="1"]').mask('00:00');
	 $('input[date="1"]').datepicker($.datepicker.regional["fr"]);
	 $('input[date="1"]').datepicker("option", "dateFormat", "dd/mm/yy");
  	 
	 $('input[phone="1"]').mask('00 00 00 00 00');
    // Format
    $('input[mtt="1"]').autoNumeric('init', {aSep: '', vMax: 999999999.999});
	$('input[qte="1"]').autoNumeric('init', {aSep: '', mDec:"0"});

}

function callCtrlAndEval(targetUrl, functionToEval, formId, closeModal){
	showSpinner();
	
	if(!formId || formId == null){
		formId = "data_form";
	}
	
	var formData = new FormData($("#"+formId)[0]);
	$.ajax({
        beforeSend: function(data) {
        },
        url: targetUrl,
        data: formData,
        type: "POST",
        cache: false,
        //dataType: 'text',
        contentType: false, // obligatoire pour de l'upload
        processData: false, // obligatoire pour de l'upload
        error: function(data) {
            hideSpinner();
        },
        success: function(data) { 
        	// Cas message succes simple
        	if(data == 'SUCCES'){// ------------------------------------------
        		hideSpinner();
        		
        		var messageTxt = "La mise &agrave; jour est effectu&eacute;e avec succ&egrave;s.";
        		alertify.success(messageTxt);
        		
          		if(functionToEval && functionToEval != ''){
        			eval(functionToEval);
        		}
        		return;
        	}// ---------------------------------------------------------------

        	//alert(data);
        	hideSpinner();
        	
    		if(data.indexOf("\":\"") != -1 && data.indexOf(">") == -1){
    			var jsonResponse = jQuery.parseJSON(data);	
        		for (var key in jsonResponse) {
        			if(key == 'popoMsg'){
        		        alertify.set({
        		            labels: {
        		              ok: "Fermer"
        		            },
        		            delay: 5000,
        		            buttonReverse: false,
        		            buttonFocus: "ok"
        		          });
        				alertify.alert(jsonResponse[key]);
        			} else{
        				if (jsonResponse.hasOwnProperty(key)) {
        					$('<label class="error_label">'+jsonResponse[key]+'</label>').insertAfter("#"+key);
	        			}
        			}
        		}
        		alertify.error("Des erreurs de saisie ont &eacute;t&eacute; trouv&eacute;es.<br> Veuillez corriger le formulaire.");
    		} else{
        		if(functionToEval && functionToEval != ''){
        			eval(functionToEval);
        		}
        		if(closeModal && $("#close_modal").length > 0){
    				$("button[id^='close_modal']").trigger("click");
    			}
        	}
        }
	});
}

function runFunc(formId, callBack, ctrl, act, wid){
	// Errase all labels
	$(".error_label").each(function(){
		$(this).css("display", "none");
		$(this).text("");
	});
	showSpinner();
	
	if($("#data").length == 0){
		$('<input>').attr({type: 'hidden',id: 'data',name: 'data',value: $("#curr_data").attr("data")}).appendTo($('#'+formId));
		$('<input>').attr({type: 'hidden',id: 'data_domaine',name: 'data_domaine',value: $("#curr_domaine").attr("data")}).appendTo($('#'+formId));
	}
	
	var formData = new FormData($("#"+formId)[0]);
	$.ajax({
        beforeSend: function(data) {
        },
        url: "page-"+ctrl+"-"+act+"&wid="+wid,
        data: formData,
        type: "POST",
        cache: false,
        //dataType: 'text',
        contentType: false,
        processData: false,
        error: function(data) {
            hideSpinner();
        },
        success: function(data) {
        	hideSpinner();
        	//
    		if(data.indexOf("\":\"") != -1 && data.indexOf(">") == -1){
    			var jsonResponse = jQuery.parseJSON(data);	
        		for (var key in jsonResponse) {
        			if(key == 'popoMsg'){
        		        alertify.set({
        		            labels: {
        		              ok: "Fermer"
        		            },
        		            delay: 5000,
        		            buttonReverse: false,
        		            buttonFocus: "ok"
        		          });
        				alertify.alert(jsonResponse[key]);
        			} else{
        				if (jsonResponse.hasOwnProperty(key)) {
        					$('<label class="error_label">'+jsonResponse[key]+'</label>').insertAfter("#"+key);
	        			}
        			}
        		}
        		alertify.error("Des erreurs de saisie ont &eacute;t&eacute; trouv&eacute;es.<br> Veuillez corriger le formulaire.");
    		}else{
    			if($("#close_modal").length > 0){
    				$("#close_modal").trigger("click");
    			}
    			if(callBack && callBack != ''){
    				eval(callBack);
    			}
    			//
    			if(data.indexOf('forward:') != -1){
         			window.location = data.substring(data.indexOf(":")+1, data.length);
         		} else {
         			$('.dashboard-wrapper').html(data);
         		}
    		}
        }
	});
}

/**
* Show loading animation
*/
function showSpinner(){
	$('#spinner').show();
}

/**
 * Hide loading img
 */
function hideSpinner(){
	$("#spinner").hide();
}

/**
 * Dynamic confirm dialog
 * @param selector
 * @param msg
 */
function addGenericConfirmAction(selector, msg){
		var likRef = $(this);
		 alertify.set({
	          labels: {
	            ok: "Confirmer",
	            cancel: "Fermer"
	          },
	          delay: 5000,
	          buttonReverse: false,
	          buttonFocus: "ok"
	        });
	        
        alertify.confirm(
        		'<div class="notice green"><p>'+msg+'</p></div>', function (e) {
          if (e) {
        	  $("#generic_lnk").attr("wact", selector.attr("ctrl"));
			  $("#generic_lnk").trigger("click");
          }
        });
}

/**
 * @param selector
 */
function forceReadOnly(selector, forceReadOnly){
	if($("#NO_RIGHT_MANAGE").length > 0 && !forceReadOnly){
		return;
	}
	selector.find("input, select, textarea").each(function(){ 
		$(this).attr("disabled", "disabled");
	});
	setTimeout(function(){
		$("input[id$='_flexselect']").each(function(){
			$(this).attr("disabled", "disabled");
		});
	});
	$("#save_submit, #activate_lnk, #add_ctrl, a[id='delete_data'], a[id='generate_code'], a[id^='add_ctrl_']").each(function(){
		$(this).remove();
	});
	$("#modalMd").find("input, select, textarea").each(function(){
		$(this).attr("disabled", "disabled");
	});
	$(".wysihtml5-toolbar").remove();
}

/**
 * @param selector
 */
function forceFindReadOnly(selector, forceReadOnly){
	if($("#NO_RIGHT_MANAGE").length > 0 && !forceReadOnly){
		return;
	}
	$("#modalMd").find("input, select, textarea").each(function(){
		$(this).attr("disabled", "disabled");
	});
	$("a[id='delete_data'], a[id='activate_lnk'], #edit_multi_lnk").each(function(){
		$(this).remove();
	});
	
	$(".custom-search").find("a").each(function(){
		if($(this).attr("id") == "edit_lnk"){
			$(this).remove();	
		}
	});
	// Resize edit
	$("a[id='edit_lnk']").css("width", "60px").css("display", "inline-block");
}

function resetForm(formId){
	$(".error_label").each(function(){
		$(this).remove();
	});
	
	$("#"+formId).find(':input').each(function(){
		$(this).val('');
	});
	$("#"+formId).find('select').each(function(){
		$(this).val('');
	});
}

function manageSpinBtn($button){
	var oldValue = $button.parent().find("input").val();
	if ($button.text() == "+") {
		var newVal = parseFloat(oldValue) + 1;
	} else {
		if (oldValue > 1) {
			var newVal = parseFloat(oldValue) - 1;
		} else {
			newVal = 1;
		}
	}
	$button.parent().find("input").val(newVal);
}