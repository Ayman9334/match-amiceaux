const Galerie = () => {
    return (
        <section className="gallery-area">
            <div className="container">
                <div className="row">
                    <div className="col-lg-8 col-md-12">
                        <div className="image-gallery">
                            <div className="sec-title">
                                <h5>
                                    Gallerie photosR
                                    <i className="fa fa-caret-right" />
                                </h5>
                            </div>
                            <div className="image-gallery-box">
                                <div className="gallery-slider owl-carousel">
                                    <div className="gallery-item">
                                        <img
                                            src="view/resources/img/template/gallery-image-1.jpg"
                                            alt=""
                                            className="img-fluid"
                                        />
                                        <div className="gallery-content">
                                            <p>
                                                <a href="#">
                                                    This handout will help you understand how paragraphs are
                                                    formed. It is usually composed of several sentences that
                                                    together develop one.
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                    <div className="gallery-item">
                                        <img
                                            src="view/resources/img/template/gallery-image-2.jpg"
                                            alt=""
                                            className="img-fluid"
                                        />
                                        <div className="gallery-content">
                                            <p>
                                                <a href="#">
                                                    This handout will help you understand how paragraphs are
                                                    formed. It is usually composed of several sentences that
                                                    together develop one.
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="image-gallery-list d-flex justify-content-between">
                                <div className="gallery-list-item">
                                    <img
                                        src="view/resources/img/template/popular-10.jpg"
                                        alt=""
                                        className="gallery-img"
                                    />
                                    <div className="fc-icon">
                                        <a href="view/resources/img/template/popular-10.jpg">
                                            <i className="fa fa-camera" />
                                        </a>
                                    </div>
                                </div>
                                <div className="gallery-list-item">
                                    <img
                                        src="view/resources/img/template/popular-7.jpg"
                                        alt=""
                                        className="gallery-img"
                                    />
                                    <div className="fc-icon">
                                        <a href="view/resources/img/template/popular-7.jpg">
                                            <i className="fa fa-camera" />
                                        </a>
                                    </div>
                                </div>
                                <div className="gallery-list-item">
                                    <img
                                        src="view/resources/img/template/popular-11.jpg"
                                        alt=""
                                        className="gallery-img"
                                    />
                                    <div className="fc-icon">
                                        <a href="view/resources/img/template/popular-11.jpg">
                                            <i className="fa fa-camera" />
                                        </a>
                                    </div>
                                </div>
                                <div className="gallery-list-item">
                                    <img
                                        src="view/resources/img/template/popular-5.jpg"
                                        alt=""
                                        className="gallery-img"
                                    />
                                    <div className="fc-icon">
                                        <a href="view/resources/img/template/popular-5.jpg">
                                            <i className="fa fa-camera" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="col-lg-4 col-md-12">
                        <div className="video-gallery">
                            <div className="sec-title">
                                <h5>
                                    Videos
                                    <i className="fa fa-caret-right" />
                                </h5>
                            </div>
                            <div className="video-lg">
                                <div className="video-table">
                                    <div className="video-tablecell text-center">
                                        <a
                                            href="https://www.youtube.com/watch?v=uXFUl0KcIkA"
                                            id="video-btn"
                                        >
                                            <i className="fa fa-play" />
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div className="video-list">
                                <div className="video-list-item d-flex">
                                    <div className="vid-img">
                                        <img src="view/resources/img/template/lt-sm-9.jpg" alt="" />
                                        <a href="#">
                                            <i className="fa fa-video-camera" />
                                        </a>
                                    </div>
                                    <div className="img-content">
                                        <p>
                                            <a href="#">These sentences are select from online news.</a>
                                        </p>
                                        <span>2 minutes ago</span>
                                    </div>
                                </div>
                                <div className="video-list-item d-flex">
                                    <div className="vid-img">
                                        <img src="view/resources/img/template/lt-sm-11.jpg" alt="" />
                                        <a href="#">
                                            <i className="fa fa-video-camera" />
                                        </a>
                                    </div>
                                    <div className="img-content">
                                        <p>
                                            <a href="#">These sentences are select from online news.</a>
                                        </p>
                                        <span>42 minutes ago</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    )
}

export default Galerie
