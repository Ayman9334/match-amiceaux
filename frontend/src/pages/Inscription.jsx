/* eslint-disable react/no-unknown-property */
import { useEffect, useRef, useState } from "react";
import {
    loadCaptchaEnginge,
    LoadCanvasTemplate,
    validateCaptcha
} from 'react-simple-captcha';

import { Link } from "react-router-dom"
import axios from "axios";
import axiosClient from "../api/axios-config";

const Inscription = () => {

    const capatchainp = useRef();
    const [enums, setEnums] = useState({});

    useEffect(() => {
        window.effectCommands();

        loadCaptchaEnginge(6);

        axiosClient.get("/matchenum")
            .then(res => setEnums(res.data))
            .catch(err=> console.log(err))
    }, [])

    const doSubmit = () => {
        if (validateCaptcha(capatchainp.current.value) == true) {
            alert("Captcha Matched");
            loadCaptchaEnginge(6);
            capatchainp.current.value = "";
        } else {
            alert("Captcha Does Not Match");
            capatchainp.current.value = "";
        }
    }

    return (
        <>
            {/* Breadcrumb Area */}
            <section className="breadcrumb-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="breadcrumb-box">
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">
                                        <Link href="#">Home</Link> <i className="fa fa-angle-right" />
                                    </li>
                                    <li className="list-inline-item">Contact</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* inscription Area */}
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
                                    {enums.categories&&
                                        enums.categories.map(x=>
                                            <option key={x.code} value={x.libelle}>{x.libelle}</option>
                                        )
                                    }
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
                                <div className="col-lg-6 col-md-12 col-sm-12">
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
                                <div className="col-lg-6 col-md-12 col-sm-12">
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
                                {/* <div className="row" id="canvas_div">
                                    <canvas id="canvas" style={{ float: "left" }} />
                                    <input
                                        className="form-control"
                                        name="code"
                                        style={{ width: 150 }}
                                    />
                                </div> */}
                                <div className="row">
                                    <div className="col">
                                        <LoadCanvasTemplate />
                                    </div>
                                    <div className="col-sm-12 col-md-6">
                                        <input
                                            ref={capatchainp}
                                            placeholder="Enter Captcha"
                                            className="form-control"
                                            name="user_captcha_input"
                                            type="text"
                                        ></input>
                                    </div>
                                </div>
                            </div>
                            <div className="form-group group" style={{ marginLeft: 20 }}>
                                <div className="checkbox">
                                    <input
                                        type="checkbox"
                                        name="condition"
                                        className="form-check-input"
                                        defaultValue="OK"
                                    />
                                    <label> J&apos;accepte les conditions d&apos;utilisation</label>
                                </div>
                            </div>
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
