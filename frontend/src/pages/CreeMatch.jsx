import { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
import axiosClient from "../api/axios-config";
import Select from "react-select";
const CreeMatch = () => {
    useEffect(() => {
        window.effectCommands();
        axiosClient
            .get("/matchenum")
            .then(({ data }) => setEnums(data))
            .catch(() => (location.href = "/error-404"));
    }, []);

    const alertelment = useRef();
    const date = useRef();
    const temp = useRef();

    const [enums, setEnums] = useState({
        categories: [],
        niveaus: [],
        regions: [],
        leagues: [],
    });

    const [formMatch, setFormMatch] = useState({
        match_date: "",
        nembre_joueur: "",
        lieu: "",
        niveau: "",
        categorie: "",
        ligue: "",
        description: "",
    });

    const [errmessages, setErrMessages] = useState([]);

    const setInpMatch = (e) =>
        setFormMatch({
            ...formMatch,
            [e.target.name]: e.target.value,
        });

    const setSelectMatch = (e, choices) => {
        setFormMatch({
            ...formMatch,
            [choices.name]: e.value,
        });
    };

    const makeDate = () => {
        setFormMatch({
            ...formMatch,
            match_date : `${date.current.value} ${temp.current.value}`
        });
    }

    const submitMatch = (e) => {
        e.preventDefault();
        axiosClient.post('match',formMatch)
            .then(({data}) => {
                //
            })
            .catch(err => {
                const response = err.response;
                if (response && response.status === 422) {
                    setErrMessages(Object.values(response.data.errors))
                    alertelment.current.scrollIntoView({ behavior: 'smooth' });
                }
            })
    }

    return (
        <div>
            <div ref={alertelment} className="pt-2">
                {errmessages.length > 3 ? (
                    <div className="alert alert-danger">
                        {errmessages.slice(0, 3).map((value, index) => (
                            <p key={`${index}errmessage`}>- {value[0]}</p>
                        ))}
                        <p>...</p>
                    </div>
                ) : (
                    errmessages.length > 0 && (
                        <div className="alert alert-danger">
                            {errmessages.map((value, index) => (
                                <p key={`${index}errmessage`}>- {value[0]}</p>
                            ))}
                        </div>
                    )
                )}
            </div>
            <section className="breadcrumb-area">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="breadcrumb-box">
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">
                                        <Link href="/">Home</Link>{" "}
                                        <i className="fa fa-angle-right" />
                                    </li>
                                    <li className="list-inline-item">Compte</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section className="cree-match">
                <div className="container py-4">
                    <form onSubmit={submitMatch}>
                        <h2 className="pb-4">
                            Entrer les information du match
                        </h2>
                        <div className="row col-12 col-lg-9">
                            <div className="form-group group col-12 col-md-6 px-3">
                                <label htmlFor="match_temp">
                                    Heure du match :{" "}
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    ref={temp}
                                    type="time"
                                    id="match_temp"
                                    className="form-control"
                                    name="match_temp"
                                    onChange={makeDate}
                                    required
                                />
                            </div>
                            <div className="form-group group col-12 col-md-6 col-lg-6 px-3">
                                <label htmlFor="match_date">
                                    Date du match:{" "}
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    ref={date}
                                    type="date"
                                    id="match_date"
                                    className="form-control"
                                    name="match_date"
                                    onChange={makeDate}
                                    required
                                />
                            </div>
                            <div className="form-group group col-12 col-md-6 col-lg-6 px-3">
                                <label htmlFor="nembre_joueur">
                                    Nombre de joueurs de chaque équipe:{" "}
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    type="number"
                                    id="nembre_joueur"
                                    className="form-control"
                                    name="nembre_joueur"
                                    placeholder="Entrer un nembre entre (5-12)"
                                    min={3}
                                    max={12}
                                    onChange={setInpMatch}
                                    required
                                />
                            </div>
                            <div className="form-group group col-12">
                                <label htmlFor="lieu">
                                    Addresse :{" "}
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <textarea
                                    className="form-control"
                                    name="lieu"
                                    id="lieu"
                                    placeholder="lieu"
                                    onChange={setInpMatch}
                                    required
                                />
                            </div>
                            <div className="form-group group col-lg-6 col-12">
                                <label htmlFor="categories">Categories :</label>
                                <Select
                                    name="categorie"
                                    id="categories"
                                    options={enums.categories}
                                    className="basic-single"
                                    onChange={setSelectMatch}
                                    placeholder="Votre categories"
                                    required
                                />
                            </div>
                            <div className="form-group group col-lg-6 col-12">
                                <label htmlFor="niveaus">Niveau :</label>
                                <Select
                                    name="niveau"
                                    id="niveaus"
                                    options={enums.niveaus}
                                    className="basic-single"
                                    onChange={setSelectMatch}
                                    placeholder="Votre niveau"
                                    required
                                />
                            </div>
                            <div className="form-group group col-lg-6 col-12">
                                <label htmlFor="ligue">League :</label>
                                <Select
                                    name="ligue"
                                    id="ligue"
                                    options={enums.leagues}
                                    className="basic-single"
                                    onChange={setSelectMatch}
                                    placeholder="Votre league"
                                    required
                                />
                            </div>
                            <div className="form-group group col-12">
                                <label htmlFor="description">
                                    Description :{" "}
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <textarea
                                    className="form-control"
                                    name="description"
                                    id="description"
                                    placeholder="description"
                                    onChange={setInpMatch}
                                    minLength={30}
                                    required
                                />
                            </div>
                            <div className="m-auto">
                                <button className="btn btn-success">
                                    Ajouter le match
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    );
};

export default CreeMatch;
