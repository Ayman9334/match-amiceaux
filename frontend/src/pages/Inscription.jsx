import { useEffect } from "react";

const Inscription = () => {
    useEffect(() => {
        window.effectCommands();
    })

    return (
        <>
            <section className="breadcrumb-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="breadcrumb-box">
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">
                                        <a href="#">Home</a> <i className="fa fa-angle-right" />
                                    </li>
                                    <li className="list-inline-item">Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {/* End Breadcrumb Area */}
            {/* News Area */}
            <section className="news-area">
                <div className="container">
                    <div className="row" style={{ marginTop: 20 }}>
                        <div
                            className="col-lg-6 col-md-6 col-sm-6"
                            style={{ borderRight: "1px solid #d9d1c5" }}
                        >
                            <h2>Informations personnelle</h2>
                            <div className="form-group group">
                                <label htmlFor="log-password2">
                                    Nom ou prénom visible dans la liste des matchs
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="nom_reel"
                                    id="nom_reel"
                                    style={{ width: "70%" }}
                                    placeholder="Nom ou prénom visible"
                                    defaultValue=""
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="rf-email">
                                    Identifiant de connexion<span style={{ color: "orange" }}>*</span>
                                    <span style={{ fontSize: 12, color: "gray" }}>(votre Email)</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="mail"
                                    id="mail"
                                    style={{ width: "70%" }}
                                    placeholder="Votre mail"
                                    defaultValue=""
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="rf-password">
                                    Confirmer Email<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="mail_confirm"
                                    id="mail_confirm"
                                    style={{ width: "70%" }}
                                    placeholder="Confirmation mail"
                                    defaultValue=""
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="rf-email">Téléphone portable</label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="portable"
                                    id="portable"
                                    // eslint-disable-next-line react/no-unknown-property
                                    phone={1}
                                    style={{ width: "50%" }}
                                    placeholder="Votre portable"
                                    defaultValue=""
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="rf-email">
                                    Quand un nouveau match est créé, si vos catégories sont les mêmes
                                    que le match vous recevez un email
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <select
                                    className="form-control"
                                    name="categories[]"
                                    id="categories"
                                    multiple="multiple"
                                    placeholder="Vos catégories"
                                >
                                    <option value="" />
                                    <option value={2}>Seniors</option>
                                    <option value={13}>U10</option>
                                    <option value={28}>U10 Féminine</option>
                                    <option value={12}>U11</option>
                                    <option value={27}>U11 Féminine</option>
                                    <option value={11}>U12</option>
                                    <option value={26}>U12 Féminine</option>
                                    <option value={10}>U13</option>
                                    <option value={25}>U13 Féminine</option>
                                    <option value={9}>U14</option>
                                    <option value={24}>U14 Féminine</option>
                                    <option value={8}>U15</option>
                                    <option value={23}>U15 Féminine</option>
                                    <option value={7}>U16</option>
                                    <option value={22}>U16 Féminine</option>
                                    <option value={6}>U17</option>
                                    <option value={21}>U17 Féminine</option>
                                    <option value={5}>U18</option>
                                    <option value={20}>U18 Féminine</option>
                                    <option value={4}>U19</option>
                                    <option value={19}>U19 Féminine</option>
                                    <option value={3}>U20</option>
                                    <option value={18}>U20 Féminine</option>
                                    <option value={17}>U6</option>
                                    <option value={32}>U6 Féminine</option>
                                    <option value={16}>U7</option>
                                    <option value={31}>U7 Féminine</option>
                                    <option value={15}>U8</option>
                                    <option value={30}>U8 Féminine</option>
                                    <option value={14}>U9</option>
                                    <option value={29}>U9 Féminine</option>
                                    <option value={1}>Vétérans</option>
                                </select>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-sm-6">
                            <h2>Informations générales</h2>
                            <div className="form-group group">
                                <label htmlFor="log-email2">
                                    Nom réel du club <span style={{ color: "orange" }}>*</span>
                                    <span style={{ fontSize: 12, color: "gray" }}>
                                        (Pas le nom de la ville)
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="nom_club"
                                    id="nom_club"
                                    placeholder="Nom du club"
                                    defaultValue=""
                                />
                            </div>
                            {/* 		       <div class="form-group group"> */}
                            {/*                     <label for="log-password2">* Région</label> */}
                            {/*                     <select class="form-control" name="region_id" id="region_id" placeholder="Votre région"> */}
                            {/*                     	<option value=""></option> */}
                            {/*                     </select> */}
                            {/*                   </div> */}
                            {/*               <div class="form-group group"> */}
                            {/*                 <label for="log-password2">* Département</label> */}
                            {/*                 <select class="form-control" name="departement_id" id="departement_id" placeholder="Votre département"> */}
                            {/*                 	<option value=""></option> */}
                            {/*                 </select> */}
                            {/*               </div> */}
                            <div className="form-group group">
                                <label htmlFor="log-password2">
                                    Ville<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control"
                                    name="villeRefAuto"
                                    id="villeRefAuto"
                                    autoComplete="off"
                                    placeholder="Votre ville"
                                    defaultValue=""
                                />
                                <div id="ville_lib" />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="log-password2">Addresse</label>
                                <textarea
                                    className="form-control"
                                    name="adresse"
                                    id="adresse"
                                    style={{ width: "70%" }}
                                    placeholder="Adresse"
                                    defaultValue={" "}
                                />
                            </div>
                            <hr />
                            <div className="form-group group">
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <label htmlFor="rf-password">
                                        Mot de passe<span style={{ color: "orange" }}>*</span>
                                    </label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="pw"
                                        id="pw"
                                        placeholder="Votre mot de passe"
                                        defaultValue=""
                                    />
                                </div>
                                <div className="col-lg-6 col-md-6 col-sm-6">
                                    <label htmlFor="rf-password">
                                        Confirmation mot de passe
                                        <span style={{ color: "orange" }}>*</span>
                                    </label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="pw_confirm"
                                        id="pw_confirm"
                                        placeholder="Confirmation"
                                        defaultValue=""
                                    />
                                </div>
                            </div>
                            <div className="form-group group">
                                <label htmlFor="rf-password-repeat">
                                    Recopier le text suivant<span style={{ color: "orange" }}>*</span>
                                </label>
                                <div className="row" id="canvas_div">
                                    <canvas id="canvas" style={{ float: "left" }} />
                                    <input
                                        className="form-control"
                                        name="code"
                                        style={{ width: 150 }}
                                    />
                                </div>
                            </div>
                            {/* <div className="form-group group" style={{ marginLeft: 20 }}>
                                <div className="checkbox">
                                    <input
                                        type="checkbox"
                                        name="condition"
                                        id="condition"
                                        defaultValue="OK"
                                        style={{ height: 30, width: 30, marginTop: "-3px" }}
                                    />
                                    <label> J&apos;accepte les conditions d&apos;utilisation</label>
                                </div>
                            </div> */}
                        </div>
                    </div>
                    <div className="row" style={{ paddingLeft: "25%" }}>
                        <input
                            className="btn btn-success"
                            type="button"
                            id="validate_cpt"
                            eval="resetForm('registr-form')"
                            defaultValue="Créer mon compte"
                        />
                        <input
                            type="button"
                            id="validate_cpt2"
                            style={{ display: "none" }}
                            targetdiv="regiter_div"
                            wact="YWRtaW4udXNlci5tZXJnZS4w"
                        />
                    </div>
                </div>
            </section>
        </>

    )
}

export default Inscription
