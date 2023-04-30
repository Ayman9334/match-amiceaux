import { useEffect, useState } from "react"
import axiosClient from "../api/axios-config";

const MatchsTable = () => {
    const [matchsdata, setMatchsdata] = useState([]);
    const [err,seterr] =useState(false)
    useEffect(() => {
        axiosClient.get('/match')
            .then(res => setMatchsdata(res.data))
            .catch(() => seterr(true))
    },[]);
    return (
        <div className="container">
            <div className="row">
                <div className="row" style={{ marginTop: 30 }}>
                    <form
                        id="registr-form"
                        className="registr-form"
                        style={{ width: "100%" }}
                    >
                        <div className="inner" style={{ width: "100%" }}>
                            <table className="table" style={{ width: "100%" }}>
                                <thead>
                                    <tr>
                                        <th style={{ width: 150 }} scope="col">
                                            Date{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th scope="col">
                                            Description{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th style={{ width: 150 }} scope="col">
                                            Niveau{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th style={{ width: 120 }} scope="col">
                                            Catégories{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th scope="col">
                                            Club{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th scope="col">
                                            Ville{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th style={{ width: 150 }} scope="col">
                                            Résultat{" "}
                                            <span className="toggles">
                                                <i className="fa fa-caret-up" />
                                                <i className="fa fa-caret-down" />
                                            </span>
                                        </th>
                                        <th style={{ width: 140 }} />
                                    </tr>
                                </thead>
                                <tbody>
                                    {matchsdata.map(match => <tr key={match.id}>
                                        <td>{match.match_date}</td>
                                        <td>{match.description}</td>
                                        <td>{match.niveau}</td>
                                        <td>{match.categorie}</td>
                                        <td>not for now</td>
                                        <td>{match.lieu}</td>
                                        <td>x-x</td>
                                    </tr>)}
                                    {err && <tr>
                                        <td colSpan={8}>nous avons un problème, veuillez réessayer plus tard</td>
                                    </tr>}
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <hr />
                <div className="row" style={{ textAlign: "center" }} id="pager">
                    <nav aria-label="Page navigation">
                        <ul className="pagination">
                            <li>
                                <span style={{ color: "gray" }} aria-hidden="true">
                                    «
                                </span>
                            </li>
                            <li>&nbsp;&nbsp; Page 1 / 0 &nbsp;&nbsp;</li>
                            <li>
                                <span style={{ color: "gray" }} aria-hidden="true">
                                    »
                                </span>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    )
}

export default MatchsTable
