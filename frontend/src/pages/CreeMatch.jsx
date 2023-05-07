import { useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom"
import axiosClient from "../api/axios-config";

const CreeMatch = () => {
    useEffect(() => {
        window.effectCommands();
        axiosClient.get("/matchenum")
            .then(({ data }) => setEnums(data))
            .catch(err => location.href = '/error-404')
    }, [])

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
        match_date: '',
        lieu: '',
        niveau: '',
        categorie: '',
        league: '',
        description: '',
    })
    const [errmessages, setErrMessages] = useState([]);
    const setInpMatch = (e) => setFormMatch({
        ...formMatch,
        [e.target.name]: e.target.value,
    })

    const setSelectMatch = (e, choices) => {
        setFormMatch({
            ...formMatch,
            [choices.name]: e.value,
        })
    }

    return (
        <div>
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
            <section className="cree-match">
                <div className="container">
                    <form action="">
                        <h2 className="py-2">Entrer les information du match</h2>
                        <div className="row">
                            <div className="form-group group col-12 col-md-6 px-3">
                                <label htmlFor="match_date">
                                    Nom ou prénom visible dans la liste des matchs
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    ref={temp}
                                    type="time"
                                    id="match_date"
                                    className="form-control"
                                    name="match_date"
                                    onChange={setInpMatch}
                                    required
                                />
                            </div>
                            <div className="form-group group col-12 col-md-6 px-3">
                                <label htmlFor="match_date">
                                    Nom ou prénom visible dans la liste des matchs
                                    <span style={{ color: "orange" }}>*</span>
                                </label>
                                <input
                                    ref={date}
                                    type="datetime-local"
                                    id="match_date"
                                    className="form-control"
                                    name="match_date"
                                    onChange={setInpMatch}
                                    required
                                />
                            </div>

                        </div>
                    </form>


                </div>
            </section>
        </div>
    )
}

export default CreeMatch
