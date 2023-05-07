import { useRef, useState } from 'react'
import { Link } from 'react-router-dom'
import axiosClient from '../api/axios-config';
import { useStateContext } from '../context/ContextProvider';

const LoginPopup = () => {
    const { setUser, setToken } = useStateContext()
    const exitpopup = useRef();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    // const [remember,setRemember] = useState(false);
    const [errMessages, setErrMessages] = useState()

    const submitLogin = (e) => {
        e.preventDefault();
        const formData = {
            email : email,
            password : password
        };
        axiosClient.post('/auth/login', formData)
            .then(({ data }) => {
                setUser(data.user);
                setToken(data.token);
                location.href = '/'
            })
            .catch(err => {
                const response = err.response;
                if (response && response.status === 422) {
                    setErrMessages(response.data.errors)
                    console.log(response.data.errors)
                }
            })

    }

    return (
        <div
            className="modal fade"
            id="loginModal"
            tabIndex={-1}
            role="dialog"
            aria-hidden="true"
        >
            <div className="modal-dialog">
                <div className="modal-content">
                    <div className="modal-header">
                        <button
                            ref={exitpopup}
                            type="button"
                            className="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            style={{ marginLeft: 0 }}
                        >
                            <i className="fa fa-times" />
                        </button>
                        <span>
                            Se connecter ou{" "}
                            <Link
                                to={'/inscription'}
                                onClick={() => exitpopup.current.click()}
                            >
                                <u>Créer un compte</u>
                            </Link>
                        </span>
                    </div>
                    <div className="modal-body">
                        <form className="login-form" onSubmit={submitLogin}>
                            <div className="form-group group">
                                <label htmlFor="log-email">Email</label>
                                <input
                                    onChange={(e)=> setEmail(e.target.value)}
                                    value={email}
                                    type="text"
                                    className="form-control"
                                    name="email"
                                    id="log-email"
                                    placeholder="Votre mail"
                                    required
                                />
                                <p className='text-danger'>{errMessages?.email[0]}</p>
                            </div>
                            <div className="form-group group" id="pw_div">
                                <label htmlFor="password">Mot de passe</label>
                                <input
                                    onChange={(e)=> setPassword(e.target.value)}
                                    value={password}
                                    type="password"
                                    className={"form-control"}
                                    name="password"
                                    id="password"
                                    placeholder="Votre mot de passe"
                                    required
                                />
                                <a
                                    className="help-link"
                                    href=""
                                    onClick={() => window.manageForggotPassword(true)}
                                >
                                    Mot de passe oublié ?
                                </a>
                            </div>
                            <input
                                className="btn btn-success"
                                type="submit"
                                value="Se connecter"
                            />
                        </form>
                    </div>
                </div>
                {/* /.modal-content */}
            </div>
            {/* /.modal-dialog */}
        </div>
    )
}

export default LoginPopup
