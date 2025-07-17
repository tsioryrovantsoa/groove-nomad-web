@include('include.header')

<body>
    @include('include.navigation')

    <section class="hero spad set-bg" data-setbg="{{ asset('assets/img/hero-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__text">
                        <span>Groove Nomad</span>
                        <h1>Vivez la musique, Explorez le monde</h1>
                        <p class="mt-5">
                            Première agence digitale qui transforme les festivals en aventures sur-mesure,
                            <br /> grâce à l’IA et à l’automatisation, tout en s’adaptant aux besoins de chaque membre
                            du groupe.
                        </p>
                        <a href="{{ route('request.index') }}" class="primary-btn">Créer mon expérience
                            personnalisée</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="event spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Festivals à venir</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="event__slider owl-carousel">
                    <div class="col-lg-4">
                        <div class="event__item">
                            <div class="event__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/tomorrowland.jpg') }}">
                                <div class="tag-date">
                                    <span>Juin 15, 2024</span>
                                </div>
                            </div>
                            <div class="event__item__text">
                                <h4>Tomorrowland Belgium</h4>
                                <p>
                                    <i class="fa fa-map-marker"></i> Boom, Belgique
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="event__item">
                            <div class="event__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/ultra-europe-croatia.jpg') }}">
                                <div class="tag-date">
                                    <span>Juillet 20, 2024</span>
                                </div>
                            </div>
                            <div class="event__item__text">
                                <h4>Ultra Europe Croatia</h4>
                                <p>
                                    <i class="fa fa-map-marker"></i> Split, Croatie
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="event__item">
                            <div class="event__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/electric-zoo.jpg') }}">
                                <div class="tag-date">
                                    <span>Août 10, 2024</span>
                                </div>
                            </div>
                            <div class="event__item__text">
                                <h4>Electric Zoo New York</h4>
                                <p>
                                    <i class="fa fa-map-marker"></i> Randall's Island, NYC
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="event__item">
                            <div class="event__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/edc-las-vegas.jpg') }}">
                                <div class="tag-date">
                                    <span>Septembre 5, 2024</span>
                                </div>
                            </div>
                            <div class="event__item__text">
                                <h4>EDC Las Vegas</h4>
                                <p>
                                    <i class="fa fa-map-marker"></i> Las Vegas, Nevada
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="about spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about__pic">
                        <img src="{{ asset('assets/img/about/about.png') }}" alt="" />
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__text">
                        <div class="section-title">
                            <h2>Groove Nomad</h2>
                            <h1>À propos de nous</h1>
                        </div>
                        <p>
                            Groove Nomad est la première agence digitale spécialisée dans la transformation 
                            des festivals en aventures sur-mesure. Grâce à notre technologie IA avancée, 
                            nous créons des expériences personnalisées qui s'adaptent aux préférences 
                            de chaque membre du groupe.
                        </p>
                        <a href="{{ route('request.index') }}" class="primary-btn">Créer mon expérience</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="services">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="services__left set-bg" data-setbg="{{ asset('assets/img/services/service-left.jpg') }}">
                        <a href="#" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 p-0">
                    <div class="row services__list">
                        <div class="col-lg-6 p-0 order-lg-1 col-md-6 order-md-1">
                            <div class="service__item deep-bg">
                                <img src="{{ asset('assets/img/services/service-1.png') }}" alt="" />
                                <h4>Festivals</h4>
                                <p>
                                    Découvrez les meilleurs festivals de musique 
                                    avec des expériences personnalisées.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-2 col-md-6 order-md-2">
                            <div class="service__item">
                                <img src="{{ asset('assets/img/services/service-1.png') }}" alt="" />
                                <h4>Voyages de groupe</h4>
                                <p>
                                    Organisez des voyages de groupe avec des itinéraires 
                                    adaptés aux préférences de chacun.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-4 col-md-6 order-md-4">
                            <div class="service__item deep-bg">
                                <img src="{{ asset('assets/img/services/service-1.png') }}" alt="" />
                                <h4>Accompagnement IA</h4>
                                <p>
                                    Notre IA analyse vos goûts pour créer des propositions 
                                    d'expériences sur-mesure.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0 order-lg-3 col-md-6 order-md-3">
                            <div class="service__item">
                                <img src="{{ asset('assets/img/services/service-1.png') }}" alt="" />
                                <h4>Logistique complète</h4>
                                <p>
                                    Gestion complète de la logistique : transport, hébergement, 
                                    billets et activités.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="track spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="section-title">
                        <h2>Expériences récentes</h2>
                        <h1>Témoignages clients</h1>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="track__all">
                        <a href="{{ route('request.index') }}" class="primary-btn border-btn">Créer ma demande</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7 p-0">
                    <div class="track__content nice-scroll">
                        <div class="single_player_container">
                            <h4>Expérience Tomorrowland 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_1"
                                data-url="music-files/1.mp3"></div>
                            <div class="jp-audio jp_container_1" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single_player_container">
                            <h4>Groupe Ultra Europe 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_2"
                                data-url="music-files/2.mp3"></div>
                            <div class="jp-audio jp_container_2" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single_player_container">
                            <h4>EDC Las Vegas 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_3"
                                data-url="music-files/3.mp3"></div>
                            <div class="jp-audio jp_container_3" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single_player_container">
                            <h4>Electric Zoo NYC 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_4"
                                data-url="music-files/4.mp3"></div>
                            <div class="jp-audio jp_container_4" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single_player_container">
                            <h4>Tomorrowland Winter 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_5"
                                data-url="music-files/5.mp3"></div>
                            <div class="jp-audio jp_container_5" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="single_player_container">
                            <h4>Ultra Miami 2023</h4>
                            <div class="jp-jplayer jplayer" data-ancestor=".jp_container_6"
                                data-url="music-files/6.mp3"></div>
                            <div class="jp-audio jp_container_6" role="application" aria-label="media player">
                                <div class="jp-gui jp-interface">
                                    <!-- Player Controls -->
                                    <div class="player_controls_box">
                                        <button class="jp-play player_button" tabindex="0"></button>
                                    </div>
                                    <!-- Progress Bar -->
                                    <div class="player_bars">
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div>
                                                    <div class="jp-play-bar">
                                                        <div class="jp-current-time" role="timer"
                                                            aria-label="time">
                                                            0:00
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="jp-duration ml-auto" role="timer" aria-label="duration">
                                            00:00
                                        </div>
                                    </div>
                                    <!-- Volume Controls -->
                                    <div class="jp-volume-controls">
                                        <button class="jp-mute" tabindex="0">
                                            <i class="fa fa-volume-down"></i>
                                        </button>
                                        <div class="jp-volume-bar">
                                            <div class="jp-volume-bar-value" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="track__pic">
                        <img src="{{ asset('assets/img/track-right.jpg') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="youtube spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Vidéos de festivals</h2>
                        <h1>Dernières expériences</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/tomorrowland.jpg') }}">
                            <a href="#" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        </div>
                        <div class="youtube__item__text">
                            <h4>Tomorrowland 2023 - Expérience Groove Nomad</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/ultra-europe-croatia.jpg') }}">
                            <a href="#" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        </div>
                        <div class="youtube__item__text">
                            <h4>Ultra Europe 2023 - Voyage de groupe</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="youtube__item">
                        <div class="youtube__item__pic set-bg" data-setbg="{{ asset('assets/img/festival/edc-las-vegas.jpg') }}">
                            <a href="#" class="play-btn video-popup"><i class="fa fa-play"></i></a>
                        </div>
                        <div class="youtube__item__text">
                            <h4>EDC Las Vegas 2023 - Expérience personnalisée</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Youtube Section End -->

    <!-- Countdown Section Begin -->
    <section class="countdown spad set-bg" data-setbg="{{ asset('assets/img/countdown-bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="countdown__text">
                        <h1>Tomorrowland 2025</h1>
                        <h4>Le festival commence dans</h4>
                    </div>
                    <div class="countdown__timer" id="countdown-time">
                        <div class="countdown__item">
                            <span>20</span>
                            <p>jours</p>
                        </div>
                        <div class="countdown__item">
                            <span>45</span>
                            <p>heures</p>
                        </div>
                        <div class="countdown__item">
                            <span>18</span>
                            <p>minutes</p>
                        </div>
                        <div class="countdown__item">
                            <span>09</span>
                            <p>secondes</p>
                        </div>
                    </div>
                    <div class="buy__tickets">
                        <a href="{{ route('request.index') }}" class="primary-btn">Créer mon expérience</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('include.footer')
</body>

</html>
