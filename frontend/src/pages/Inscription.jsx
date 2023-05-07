import { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom"
import axiosClient from "../api/axios-config";
import Select from 'react-select';
import { useStateContext } from "../context/ContextProvider";

const Inscription = () => {
    const { setUser, setToken } = useStateContext();
    const conditionsInp = useRef();
    const alertelment = useRef()
    const [enums, setEnums] = useState({
        categories: [],
        niveaus: [],
        regions: [],
        leagues: [],
    });

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
        categorie: '',
        league: '',
        conditions: false,
    })

    // const resetPassword = () => setFormdata({
    //     ...formdata,
    //     password : "",
    //     password_confirmation: "",
    // })

    const [errmessages, setErrMessages] = useState([]);

    useEffect(() => {
        window.effectCommands();
        axiosClient.get("/matchenum")
            .then(({ data }) => setEnums(data))
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

    const setCheckboxData = (e) => setFormdata({
        ...formdata,
        [e.target.name]: e.target.checked,
    })

    const submitData = () => {
        // eslint-disable-next-line no-constant-condition
        if (true) { //ajouter capatcha!!!!
            axiosClient.post('auth/signup', formdata)
                .then(({ data }) => {
                    setUser(data.user);
                    setToken(data.token);
                    location.href = '/'
                })
                .catch(err => {
                    const response = err.response;
                    if (response && response.status === 422) {
                        setErrMessages(Object.values(response.data.errors))
                        alertelment.current.scrollIntoView({ behavior: 'smooth' });
                    }
                })
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
                                        <Link href="/">Home</Link> <i className="fa fa-angle-right" />
                                    </li>
                                    <li className="list-inline-item">Compte</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            {/* inscription Area */}
            <section className="news-area">
                <div className="container">
                    <div ref={alertelment} className="pt-2">
                        {
                            (errmessages.length > 3) ? (
                                <div className="alert alert-danger">
                                    {errmessages.slice(0, 3).map((value, index) => <p key={`${index}errmessage`}>- {value[0]}</p>)}
                                    <p>...</p>
                                </div>
                            ) : (errmessages.length > 0) && (
                                <div className="alert alert-danger">
                                    {errmessages.map((value, index) => <p key={`${index}errmessage`}>- {value[0]}</p>)}
                                </div>
                            )
                        }
                    </div>


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
                                    Lorsqu&apos;un nouveau match est créé, si ces informations
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
                                        onChange={setSelectData}
                                        placeholder="Votre categories"
                                    />
                                </div>
                                <div className="form-group group col-lg-6 col-12">
                                    <label htmlFor="niveaus">
                                        Niveau :
                                    </label>
                                    <Select
                                        name="niveau"
                                        id="niveaus"
                                        options={enums.niveaus}
                                        className="basic-single"
                                        onChange={setSelectData}
                                        placeholder="Votre niveau"
                                    />
                                </div>
                                <div className="form-group group col-lg-6 col-12">
                                    <label htmlFor="leagues">
                                        League :
                                    </label>
                                    <Select
                                        name="league"
                                        id="leagues"
                                        options={enums.leagues}
                                        className="basic-single"
                                        onChange={setSelectData}
                                        placeholder="Votre league"
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="col-lg-6 col-md-6 col-sm-6">
                            <h2>Informations générales</h2>
                            <div className="form-group group">
                                <label htmlFor="villes">
                                    Ville :<span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="text"
                                    className="form-control w-50"
                                    name="ville"
                                    id="villes"
                                    placeholder="Votre ville"
                                    onChange={setInpData}
                                />
                                <div id="ville_lib" />
                            </div>
                            <div className="form-group group ">
                                <label htmlFor="regions">
                                    Region :<span style={{ color: "orange" }}>*</span>
                                </label>
                                <Select
                                    name="region"
                                    id="regions"
                                    options={enums.regions}
                                    className="basic-single w-50"
                                    onChange={setSelectData}
                                    placeholder="Votre region"
                                />
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
                                <label htmlFor="adresses">
                                    Addresse :<span style={{ color: "orange" }}>*</span>
                                </label>
                                <textarea
                                    className="form-control w-75"
                                    name="adresse"
                                    id="adresses"
                                    placeholder="Adresse"
                                    onChange={setInpData}
                                />
                            </div>
                            <hr />
                            <div className="form-group group">
                                <div className="col-lg-6 col-md-12 col-sm-12">
                                    <label htmlFor="pw">
                                        Mot de passe :<span style={{ color: "orange" }}>*</span>
                                    </label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="password"
                                        id="pw"
                                        placeholder="Votre mot de passe"
                                        onChange={setInpData}
                                        value={formdata.password}
                                    />
                                </div>
                                <div className="col-lg-6 col-md-12 col-sm-12">
                                    <label htmlFor="pwc">
                                        Confirmation mot de passe :
                                        <span style={{ color: "orange" }}>*</span>
                                    </label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="password_confirmation"
                                        id="pwc"
                                        placeholder="Confirmation"
                                        value={formdata.password_confirmation}
                                        onChange={setInpData}
                                    />
                                </div>
                            </div>
                            <div className="form-group group">
                                {/* <label htmlFor="rf-password-repeat">
                                    Recopier le text suivant<span style={{ color: "orange" }}>*</span>
                                </label> */}
                                {/* <div className="row" id="canvas_div">
                                    <canvas id="canvas" style={{ float: "left" }} />
                                    <input
                                        className="form-control"
                                        name="code"
                                        style={{ width: 150 }}
                                    />
                                </div> */}
                            </div>
                            <div className="form-group group" style={{ marginLeft: 20 }}>
                                <div className="checkbox">
                                    <input
                                        type="checkbox"
                                        ref={conditionsInp}
                                        name="conditions"
                                        value="checked"
                                        onChange={setCheckboxData}
                                        className="form-check-input"
                                    />
                                    <label> J&apos;accepte les conditions d&apos;utilisation</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="d-flex justify-content-center py-4">
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
