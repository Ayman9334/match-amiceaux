const PiedPage = () => {
    return (
        <>
            <footer className="footer-area">
                <footer className="footer">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-5 col-md-5 col-sm-5">
                                <div className="info">
                                    <a className="logo" href="accueil.html">
                                        <img
                                            src="view/resources/img/logo-match.png"
                                            alt="Matchs Amicaux"
                                        />
                                    </a>
                                    <p>
                                        Etablir une relation de confiance et de partenariat avec nos
                                        clients, est un préalable indispensable pour garantir la
                                        meilleure qualité de service.
                                    </p>
                                    <div className="social">
                                        <a href="#" target="_blank">
                                            <i className="fa fa-instagram" />
                                        </a>
                                        <a href="#" target="_blank">
                                            <i className="fa fa-youtube-square" />
                                        </a>
                                        <a href="#" target="_blank">
                                            <i className="fa fa-tumblr-square" />
                                        </a>
                                        <a href="#" target="_blank">
                                            <i className="fa fa-vimeo-square" />
                                        </a>
                                        <a href="#" target="_blank">
                                            <i className="fa fa-pinterest-square" />
                                        </a>
                                        <a href="#" target="_blank">
                                            <i className="fa fa-facebook-square" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div className="col-lg-4 col-md-4 col-sm-4">
                                <h2>Nos heures de disponibilité</h2>
                                <ul className="list-unstyled">
                                    <li>Lundi au vendredi de 9h00 à 12h30 &amp; 13h30 à 19h00</li>
                                    <li>Samedi de 14h00 à 19h00</li>
                                    <li>Fermé le Dimanche</li>
                                </ul>
                            </div>
                            <div className="contacts col-lg-3 col-md-3 col-sm-3">
                                <h2>Adresse</h2>
                                <p className="p-style3">
                                    135, rue des Ardennes
                                    <br />
                                    Paris 15ème arrdt
                                    <br />
                                    <a href="mailto:mail@Matchs Amicaux.com">
                                        contact@MatchsAmicaux.fr
                                    </a>
                                    <br />
                                    (+33) 01.33.78.90.42
                                    <br />
                                </p>
                            </div>
                        </div>
                        <div className="copyright">
                            <div className="row">
                                <div className="col-lg-7 col-md-7 col-sm-7">
                                    <p>
                                        © 2023 MatchsAmicaux. Tous droits résérvés Par{" "}
                                        <a href="#" target="_blank">
                                            EC
                                        </a>
                                    </p>
                                </div>
                                <div className="col-lg-5 col-md-5 col-sm-5">
                                    <div className="payment">
                                        <img
                                            src="view/resources/img/template/payment/visa.png"
                                            alt="Visa"
                                        />
                                        <img
                                            src="view/resources/img/template/payment/paypal.png"
                                            alt="PayPal"
                                        />
                                        <img
                                            src="view/resources/img/template/payment/master.png"
                                            alt="Master Card"
                                        />
                                        <img
                                            src="view/resources/img/template/payment/discover.png"
                                            alt="Discover"
                                        />
                                        <img
                                            src="view/resources/img/template/payment/amazon.png"
                                            alt="Amazon"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </footer>
            <section className="footer-btm">
                <div className="container">
                    <div className="row">
                        <div className="col-md-6">
                            <div className="copyright-text">
                                <p>
                                    Copyright © 2023 | Matchs Amicaux <i className="fa fa-heart" />{" "}
                                    par{" "}
                                    <a href="#" target="_blank">
                                        JT
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div className="col-md-6">
                            <div className="ftb-menu text-right">
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">
                                        <a href="accueil.html">Accueil</a>
                                    </li>
                                    <li className="list-inline-item">
                                        <a href="news.html">News</a>
                                    </li>
                                    <li className="list-inline-item">
                                        <a href="faq.html">FAQ</a>
                                    </li>
                                    <li className="list-inline-item">
                                        <a href="apropos.html">A propos</a>
                                    </li>
                                    <li className="list-inline-item">
                                        <a href="contact.html">Contact</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="back-to-top text-center">
                    <a data-scroll="" href="#btt">
                        <i className="fa fa-angle-up" />
                    </a>
                </div>
            </section>
        </>

    )
}

export default PiedPage
