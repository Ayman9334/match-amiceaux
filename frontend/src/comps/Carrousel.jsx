import { useEffect } from 'react'
const Carrousel = () => {
    return (<>
        {/* Web Ticker */}
        <section className="top-news" >
            <div className="container">
                <div className="news-content">
                    <div className="row">
                        <div className="col-md-12">
                            <div className="ticker d-flex">
                                <div className="news-head">
                                    <span>
                                        DERNIERES NOUVELLES
                                        <i className="fa fa-caret-right" />
                                    </span>
                                </div>
                                <ul id="webTicker">
                                    <li>
                                        <a href="#">
                                            <i className="fa fa-dot-circle-o" />
                                            Un match est organisé dans la ville de Bobigny entre les
                                            équipes A et B.
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i className="fa fa-dot-circle-o" />
                                            La fédération de Foot île de France et les équipes niveau A
                                            on trouvé un accors.
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i className="fa fa-dot-circle-o" />
                                            Démarrage de la saison du tournoi de sport collectif.
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i className="fa fa-dot-circle-o" />
                                            Nouveaux sujets de sport.
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section >
        {/* End Web Ticker */}
        {/* Slider Area */}
        <section className="slider-area">
            <div className="container">
                <div className="row">
                    <div className="col-lg-8 col-md-12 padding-fix-r">
                        <div className="owl-carousel owl-slider">
                            <div className="slider-content">
                                <img
                                    src="view/resources/img/template/gallerie/football-stadium-2.jpg"
                                    alt=""
                                    className="img-fluid"
                                />
                                <div className="slider-layer">
                                    <p>
                                        <a href="#">
                                            This handout will help you understand how paragraphs are
                                            formed. It is usually composed of several sentences that
                                            together develop one.
                                        </a>
                                    </p>
                                    <ul className="list-unstyled list-inline">
                                        <li className="list-inline-item">SPORTS</li>
                                        <li className="list-inline-item">February 11, 2019</li>
                                    </ul>
                                </div>
                            </div>
                            <div className="slider-content">
                                <img
                                    src="view/resources/img/template/gallerie/basketball-2.jpg"
                                    alt=""
                                    className="img-fluid"
                                />
                                <div className="slider-layer">
                                    <p>
                                        <a href="#">
                                            The purpose of this handout is to give some basic
                                            instruction. It is usually composed of several sentences
                                            that together develop one.
                                        </a>
                                    </p>
                                    <ul className="list-unstyled list-inline">
                                        <li className="list-inline-item">LIFE STYLE</li>
                                        <li className="list-inline-item">February 11, 2019</li>
                                    </ul>
                                </div>
                            </div>
                            <div className="slider-content">
                                <img
                                    src="view/resources/img/template/gallerie/rugby-1.jpg"
                                    alt=""
                                    className="img-fluid"
                                />
                                <div className="slider-layer">
                                    <p>
                                        <a href="#">
                                            It is usually composed of several sentences that together
                                            develop one. It is usually composed of several sentences
                                            that together develop one.
                                        </a>
                                    </p>
                                    <ul className="list-unstyled list-inline">
                                        <li className="list-inline-item">FOOD</li>
                                        <li className="list-inline-item">February 11, 2019</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4 col-md-12 slider-fix">
                        <div className="slider-sidebar sidebar-o">
                            <img
                                src="view/resources/img/template/gallerie/soccer-3.jpg"
                                alt=""
                                className="img-fluid"
                            />
                            <div className="sidebar-layer">
                                <p>
                                    <a href="#">
                                        It is usually composed of several sentences that together
                                        develop one.
                                    </a>
                                </p>
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">TECHNOLOGY</li>
                                    <li className="list-inline-item">February 11, 2019</li>
                                </ul>
                            </div>
                        </div>
                        <div className="slider-sidebar">
                            <img
                                src="view/resources/img/template/gallerie/football-1.jpg"
                                alt=""
                                className="img-fluid"
                            />
                            <div className="sidebar-layer">
                                <p>
                                    <a href="#">
                                        These sentences are selected from various online news.
                                    </a>
                                </p>
                                <ul className="list-unstyled list-inline">
                                    <li className="list-inline-item">HEALTH</li>
                                    <li className="list-inline-item">February 11, 2019</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {/* End Slider Area */}
    </>
    )
}

export default Carrousel
