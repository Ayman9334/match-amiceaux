
import { useEffect, useRef, useState } from "react";
import {
    loadCaptchaEnginge,
    LoadCanvasTemplate,
    validateCaptcha
} from 'react-simple-captcha';
import { Link } from "react-router-dom"
import axiosClient from "../api/axios-config";
import Select from 'react-select';

const Inscription = () => {

    const capatchaInp = useRef();
    const conditionsInp = useRef();
    const [enums, setEnums] = useState({ categories: [] });
    const [formdata, setFormdata] = useState({
        nom: '',
        email: '',
        email_confirmation: '',
        password: '',
        password_confirmation: '',
        n_telephone: '',
        code_postal: '',
        ville: '',
        region: '',
        adresse: '',
        niveau: '',
        categorie: [],
        league: '',
    })

    useEffect(() => {
        window.effectCommands();

        loadCaptchaEnginge(6);

        axiosClient.get("/matchenum")
            .then(res => setEnums(res.data))
            .catch(err => console.log(err))
    }, [])

    const setInpData = (e) => setFormdata({
        ...formdata,
        [e.target.name]: e.target.value,
    })

    const setSelectData = (e, choices) => {
        setFormdata({
            ...formdata,
            [choices.name]: e.value,
        })
    }

    const doSubmit = () => {
        if (validateCaptcha(capatchaInp.current.value) == true) {
            alert("Captcha Matched");
            loadCaptchaEnginge(6);
            capatchaInp.current.value = "";
        } else {
            alert("Captcha Does Not Match");
            capatchaInp.current.value = "";
        }
    }

    const submitData = () => {
        //
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
                                <label htmlFor="nom">
                                    Nom ou prénom visible dans la liste des matchs
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nom"
                                    className="form-control w-75"
                                    name="nom"
                                    placeholder="Nom ou prénom visible"
                                    onChange={setInpData}
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="email">
                                    Identifiant de connexion<span style={{ color: "orange" }}>*</span>
                                    <span style={{ fontSize: 12, color: "gray" }}>(votre Email)</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control w-75"
                                    name="email"
                                    id="email"
                                    placeholder="Votre mail"
                                    onChange={setInpData}
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="emailConfirm">
                                    Confirmer Email<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control w-75"
                                    name="email_confirmation"
                                    id="emailConfirm"
                                    placeholder="Confirmation mail"
                                    onChange={setInpData}
                                />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="telephone">Téléphone portable</label>
                                <input
                                    type="text"
                                    className="form-control w-50"
                                    name="n_telephone"
                                    id="telephone"
                                    placeholder="Votre portable"
                                    onChange={setInpData}
                                />
                            </div>

                            <div className="form-group group row">
                                <p className="font-weight-bold py-2 col-12">
                                    Lorsqu'un nouveau match est créé, si ces informations
                                    ci-dessous sont les mêmes que le match, vous recevez un e-mail
                                    <span style={{ color: "orange" }}>*</span>
                                </p>
                                <div className="form-group group col-lg-6 col-12">
                                    <label htmlFor="categories">
                                        Categories :
                                    </label>
                                    <Select
                                        name="categorie"
                                        id="categories"
                                        options={enums.categories}
                                        className="basic-single"
                                        classNamePrefix="select-cat"
                                        onChange={setSelectData}
                                        placeholder="Votre categories"
                                    />
                                </div>
                                <div className="form-group group col-lg-6 col-12">
                                    <label htmlFor="niveau">
                                        Niveau :
                                    </label>
                                    <Select
                                        name="niveau"
                                        id="niveau"
                                        options={enums.categories}
                                        className="basic-single"
                                        classNamePrefix="select-niv"
                                        onChange={setSelectData}
                                        placeholder="Votre categories"
                                    />
                                </div>
                                
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-sm-6">
                            <h2>Informations générales</h2>
                            <div className="form-group group">
                                <label htmlFor="log-password2">
                                    Ville<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control w-50"
                                    name="villeRefAuto"
                                    id="villeRefAuto"
                                    autoComplete="off"
                                    placeholder="Votre ville"
                                    defaultValue=""
                                />
                                <div id="ville_lib" />
                            </div>
                            <div className="form-group group">
                                <label htmlFor="zipcode">
                                    Code postale :<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control w-50"
                                    name="code_postal"
                                    id="zipcode"
                                    placeholder="Votre zip code"
                                    onChange={setInpData}
                                />
                            </div>

                            <div className="form-group group">
                                <label htmlFor="log-password2">
                                    Addresse<span style={{ color: "orange" }}>*</span>
                                </label>
                                <textarea
                                    className="form-control w-75"
                                    name="adresse"
                                    id="adresse"
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
                                            ref={capatchaInp}
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
                                        ref={conditionsInp}
                                        name="condition"
                                        className="form-check-input"
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
                            onClick={submitData}
                            value="Créer mon compte"
                        />
                    </div>
                </div>
            </section>
        </>

    )
}

export default Inscription
