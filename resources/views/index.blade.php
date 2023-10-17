<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--  UNICONS  -->
    <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
    />

    <!--  SWIPER CSS  -->
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css" />
    <!--  CSS  -->
    <link rel="stylesheet" href="assets/css/styles.css" />

    <title>Responsive Portfolio Website</title>
</head>
<body>
    <!--  HEADER  -->
    <header class="header" id="header">
    <nav class="nav container">
        <a href="#" class="nav_logo"
        >Leymat <br />
        Nicolas</a
        >
        <div class="nav_menu" id="nav-menu">
        <ul class="nav_list grid">
            <li class="nav_item">
            <a href="#home" class="nav_link active-link">
                <i class="uil uil-estate nav_icon"></i> Home
            </a>
            </li>

            <li class="nav_item">
            <a href="#about" class="nav_link">
                <i class="uil uil-user nav_icon"></i> About
            </a>
            </li>

            <li class="nav_item">
            <a href="#skills" class="nav_link">
                <i class="uil uil-file-alt nav_icon"></i> Skills
            </a>
            </li>

            <li class="nav_item">
            <a href="#services" class="nav_link">
                <i class="uil uil-briefcase-alt nav_icon"></i> Services
            </a>
            </li>

            <li class="nav_item">
            <a href="#portfolio" class="nav_link">
                <i class="uil uil-scenery nav_icon"></i> Portfolio
            </a>
            </li>
            <li class="nav_item">
            <a href="#contact" class="nav_link">
                <i class="uil uil-message nav_icon"></i> Contact Me
            </a>
            </li>
        </ul>
        <i class="uil uil-times nav_close" id="nav-close"></i>
        </div>
        <div class="nav_btns">
        <i class="uil uil-moon change-theme" id="theme-button"></i>
        <div class="nav_toggle" id="nav-toggle">
            <i class="uil uil-apps"></i>
        </div>
        </div>
    </nav>
    </header>
    <!--  HEADER FIN  -->

    <!--  MAIN   -->
    <main class="main">
    <!-- HOME -->
    <section class="home section" id="home">
        <div class="home_container container grid">
          <div class="home_content grid">
            <div class="home_social">
              <a
                href="https://github.com/NicolasLeymat"
                target="_blank"
                class="home_social-icon"
              >
                <i class="uil uil-github"></i>
              </a>
              <!-- <a href="" target="_blank" class="home_social-icon">

              </a>
              <a href="" target="_blank" class="home_social-icon">

              </a> -->
            </div>

            <div class="home_img">
              <svg
                class="home_blob"
                viewBox="0 0 200 187"
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
              >
                <mask id="mask0" mask-type="alpha">
                  <path
                    d="M190.312 36.4879C206.582 62.1187 201.309 102.826 182.328 134.186C163.346 165.547 
                    130.807 187.559 100.226 186.353C69.6454 185.297 41.0228 161.023 21.7403 129.362C2.45775 
                    97.8511 -7.48481 59.1033 6.67581 34.5279C20.9871 10.1032 59.7028 -0.149132 97.9666 
                    0.00163737C136.23 0.303176 174.193 10.857 190.312 36.4879Z"
                  />
                </mask>
                <g mask="url(#mask0)">
                  <path
                    d="M190.312 36.4879C206.582 62.1187 201.309 102.826 182.328 134.186C163.346 
                    165.547 130.807 187.559 100.226 186.353C69.6454 185.297 41.0228 161.023 21.7403 
                    129.362C2.45775 97.8511 -7.48481 59.1033 6.67581 34.5279C20.9871 10.1032 59.7028 
                    -0.149132 97.9666 0.00163737C136.23 0.303176 174.193 10.857 190.312 36.4879Z"
                  />
                  <image
                    class="home_blob-img"
                    x="0"
                    y="0"
                    href="assets/img/perfil.png"
                    alt="MA TETE"
                  />
                </g>
              </svg>
            </div>

            <div class="home_data">
              <h1 class="home_title">Bonjour, je suis Nicolas Leymat</h1>
              <h3 class="home_subtitle">Développeur</h3>
              <p class="home_description">
                Je fait du développement en tout genre principalement du
                back-end mais aussi front-end.
              </p>

              <a href="#contact" class="button button--flex">
                Contact Me <i class="uil uil-message button_icon"></i>
              </a>
            </div>
          </div>
          <div class="home_scroll">
            <a href="#about" class="home_scroll-button button--flex">
              <i class="uil uil-mouse-alt home_scroll-mouse"></i>
              <span class="home_scroll-name">Scroll down</span>
              <i class="uil uil-arrow-down home_scroll-arrow"></i>
            </a>
          </div>
        </div>
      </section>
      <!-- HOME FIN -->

      <!-- ABOUT -->
      <section class="about section" id="about">
        <h2 class="section_title">À propos de moi</h2>
        <span class="section_subtitle">Information sur moi</span>

        <div class="about_container container grid">
          <img src="" alt="about Me image" class="about_img" />
          <div class="about_data">
            <p class="about_description">
              Je suis développeur back-end principalement mais aussi front-end,
              j'ai commencé à développé quand j'avais 13 ans, en commencant par
              java.
            </p>
            <div class="about_info">
              <span class="about_info-title">07</span>
              <span class="about_info-name"
                >Années <br />
                d'expériences</span
              >

              <span class="about_info-title">04</span>
              <span class="about_info-name"
                >Projet <br />
                Completer</span>

              <span class="about_info-title">1+</span>
              <span class="about_info-name"
                >Entreprise <br />
                </span>
            </div>
          </div>

          <div class="about_buttons">
            <a
              download=""
              href="assets/pdf/Cv_Leymat_Nicolas_Version_Française.pdf"
              class="button button--flex"
            >
              Download CV<br />
              Version française
              <i class="uil uil-download-alt button_icon"></i>
            </a>
          </div>
        </div>
      </section>
      <!-- ABOUT FIN -->

      <!-- SKILLS -->
      <section class="skills section" id="skills">
        <h2 class="section_title">Skills</h2>
        <span class="section_subtitle">Mon niveau</span>

        <div class="skills_container container grid">
          <div>
            <div class="skills_content skills_open">
              <div class="skills_header">
                <i class="uil uil-brackets-curly skills_icon"></i>

                <div>
                  <h1 class="skills_title">Back-end Developpement</h1>
                  <span class="skills_subtitle">7 ans</span>
                </div>

                <i class="uil uil-angle-down skills_arrow"></i>
              </div>
              <div class="skills_list grid">
                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Php</h3>
                    <span class="skills_number">50%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_php"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Java</h3>
                    <span class="skills_number">75%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_java"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">C#</h3>
                    <span class="skills_number">50%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_cSharp"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Sql</h3>
                    <span class="skills_number">50%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_sql"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Python</h3>
                    <span class="skills_number">50%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_py"></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="skills_content skills_close">
              <div class="skills_header">
                <i class="uil uil-brackets-curly skills_icon"></i>

                <div>
                  <h1 class="skills_title">Front-end Developpement</h1>
                  <span class="skills_subtitle">7 ans</span>
                </div>

                <i class="uil uil-angle-down skills_arrow"></i>
              </div>
              <div class="skills_list grid">
                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">HTML</h3>
                    <span class="skills_number">90%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_html"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">CSS</h3>
                    <span class="skills_number">80%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_CSS"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Javascript</h3>
                    <span class="skills_number">50%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_Javascript"></span>
                  </div>
                </div>

                <div class="skills_data">
                  <div class="skills_title">
                    <h3 class="skills_name">Xml</h3>
                    <span class="skills_number">60%</span>
                  </div>
                  <div class="skills_bar">
                    <span class="skills_percentage skills_Xml"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- SKILLS FIN -->

      <!-- QUALIFICATIONS -->
      <section class="qualification section">
        <h2 class="section_title">Expériences et diplôme</h2>
        <span class="section_subtitle"
          >Mes expériences professionneles et mes diplômes</span>
        </span>

        <div class="qualification_container container">
          <div class="qualification_tabs">
            <div
              class="qualification_button button--flex qualification_active"
              data-target="#education"
            >
              <i class="uil uil-graduation-cap qualification_icon"></i>
              Éducation
            </div>
            <div class="qualification_button button--flex" data-target="#work">
              <i class="uil uil-briefcase-alt qualification_icon"></i>
              Travail
            </div>
          </div>
          <div class="qualification_sections">
            <div
              class="qualification_content qualification_active"
              data-content
              id="education"
            >
              <div class="qualification_data">
                <div>
                  <h3 class="qualification_title">Baccalauréat STI2D</h3>
                  <span class="qualification_subtitle"
                    >France - Lycée Bossuet</span
                  >
                  <div class="qualification_calendar">
                    <i class="uil uil-calendar-alt"></i>
                    2018 - 2020
                  </div>
                </div>
                <div>
                  <span class="qualification_rounder"></span>
                  <span class="qualification_line"></span>
                </div>
              </div>

              <div class="qualification_data">
                <div></div>
                <div>
                  <span class="qualification_rounder"></span>
                  <!-- <span class="qualification_line"></span> -->
                </div>
                <div>
                  <h3 class="qualification_title">DUT Informatique</h3>
                  <span class="qualification_subtitle"
                    >France - Iut Paul Sabatier III</span
                  >
                  <div class="qualification_calendar">
                    <i class="uil uil-calendar-alt"></i>
                    2020 - 2022
                  </div>
                </div>
              </div>
            </div>
            <div class="qualification_content" data-content id="work">
              <div class="qualification_data">
                <div>
                  <h3 class="qualification_title">Préparateur Drive/Hôte de caisse</h3>
                  <span class="qualification_subtitle"
                    >France - Samage</span
                  >
                  <div class="qualification_calendar">
                    <i class="uil uil-calendar-alt"></i>
                    2021 - 2021
                  </div>
                </div>
                <div>
                  <span class="qualification_rounder"></span>
                  <span class="qualification_line"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- QUALIFICATIONS FIN -->

    <!-- SERVICES -->
    <section class="services section" id="services">
        <h2 class="section_title">Services</h2>
        <span class="section_subtitle">What i offer</span>

        <div class="services_container container grid">
        <!-- Services 1 -->
        <div class="services_content">
            <div>
            <i class="uil uil-android services_icon"></i>
            <h3 class="services_title">
                Android <br />
                Développeur java
            </h3>
            </div>

            <span
            class="button button--flex button--small button--link services_button"
            >
            Voir plus
            <i class="uil uil-arrow-right button_icon"></i>
            </span>

            <div class="services_modal">
            <div class="services_modal-content">
                <h4 class="services_modal-title">
                Android <br />
                Développeur java/UI/UX
                </h4>
                <i class="uil uil-times services_modal-close"></i>
                <ul class="services_modal-services grid">
                <li class="services_modal-service">
                    <i class="uil uil-check-circle services_modal-icon"></i>
                    <p>
                    Développement du back-end de votre application Android.
                    </p>
                </li>

                <li class="services_modal-service">
                    <i class="uil uil-check-circle services_modal-icon"></i>
                    <p>
                    Développement du front-end de votre application Android.
                    </p>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <!-- Services 1 Fin -->

        <!-- Services 2 -->
        <div class="services_content">
            <div>
            <i class="uil uil-brackets-curly services_icon"></i>
            <h3 class="services_title">
                Web <br />
                Développeur web
            </h3>
            </div>

            <span
            class="button button--flex button--small button--link services_button"
            >
            Voir plus
            <i class="uil uil-arrow-right button_icon"></i>
            </span>

            <div class="services_modal">
            <div class="services_modal-content">
                <h4 class="services_modal-title">
                Web <br />
                Développeur web front-end/back-end
                </h4>
                <i class="uil uil-times services_modal-close"></i>
                <ul class="services_modal-services grid">
                <li class="services_modal-service">
                    <i class="uil uil-check-circle services_modal-icon"></i>
                    <p>
                    Développement du back-end de votre site.
                    </p>
                </li>

                <li class="services_modal-service">
                    <i class="uil uil-check-circle services_modal-icon"></i>
                    <p>
                    Développement du front-end de votre site.
                    </p>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <!-- Services 2 Fin -->

                    <!-- Services 2 -->
        <div class="services_content">
            <div>
            <i class="uil uil-rocket services_icon"></i>
            <h3 class="services_title">
                Jeu Vidéo <br />
                Développeur de Jeu-vidéo
            </h3>
            </div>

            <span
            class="button button--flex button--small button--link services_button"
            >
            Voir plus
            <i class="uil uil-arrow-right button_icon"></i>
            </span>

            <div class="services_modal">
            <div class="services_modal-content">
                <h4 class="services_modal-title">
                Jeu Vidéo <br />
                Développeur de Jeu-vidéo
                </h4>
                <i class="uil uil-times services_modal-close"></i>
                <ul class="services_modal-services grid">
                <li class="services_modal-service">
                    <i class="uil uil-check-circle services_modal-icon"></i>
                    <p>
                    Développement de votre jeu vidéo.
                    </p>
                </li>
                </ul>
            </div>
            </div>
        </div>
        <!-- Services 2 Fin -->
        <!-- ... -->
        </div>
    </section>
    <!-- SERVICES FIN -->

    <!-- PORTFOLIO -->
    <section class="portfolio section" id="portfolio">
        <h2 class="section_title">Portfolio</h2>
        <span class="section_subtitle">Projet le plus récent</span>
        <div class="portfolio_container container swiper-container">
        <div class="swiper-wrapper">
            <!-- Projet 1 -->
            <div class="portfolio_content grid swiper-slide">
            <img
                src="assets/img/"
                alt="Preview pas encore disponible"
                class="portfolio_img"
            />

            <div class="portfolio_data">
                <h3 class="portfolio_title">Jeu vidéo 1</h3>
                <p class="portfolio_description">Développement d'un jeu vidéo de type 2D top-down view un peu comme the binding of isaac pour le moment enocre en cours de développement</p>
                <a
                href="https://github.com/NicolasLeymat/TopDownView2D"
                class="button button--flex button--small portfolio_button"
                >
                Plus
                <i class="uil uil-arrow-right button_icon"></i>
                </a>
            </div>
            </div>
            <!-- Projet 1 Fin -->

            <div class="portfolio_content grid swiper-slide">
            <img
                src="assets/img/"
                alt="Preview pas encore disponible"
                class="portfolio_img"
            />

            <div class="portfolio_data">
                <h3 class="portfolio_title">The idle</h3>
                <p class="portfolio_description">Jeu vdéo de type incrémental que j'ai du laissé tomber à cause de manque de connaissance en UI/UX,
                mais que je compte reprendre quand j'aurais finis mon projet actuel</p>
                <a
                href="https://github.com/NicolasLeymat/Idle"
                class="button button--flex button--small portfolio_button"
                >
            Plus
            <i class="uil uil-arrow-right button_icon"></i>
                </a>
            </div>
            </div>

            <div class="portfolio_content grid swiper-slide">
            <img
                src="assets/"
                alt="Preview"
                class="portfolio_img"
            />

            <div class="portfolio_data">
                <h3 class="portfolio_title">Projet Tuteuré</h3>
                <p class="portfolio_description">Ce projet est une application android faite dans le cadre de mon DUT informatique,
                qui permet de créer des séances de sport et de les effectués</p>
                <a
                download=""
                href="assets/apk/Ptut.apk"
                class="button button--flex button--small portfolio_button"
                >
                Application
                <i class="uil uil-arrow-right button_icon"></i>
                </a>
            </div>
            </div>

            <div class="portfolio_content grid swiper-slide">
            <img
                src="assets/"
                alt="Preview"
                class="portfolio_img"
            />

            <div class="portfolio_data">
                <h3 class="portfolio_title">Projet S4</h3>
                <p class="portfolio_description">Ce projet est une application android faite dans le cadre de mon DUT informatique,
                chercher vos plats favoris et de voir des informations dessus et aussi de voir des plats similaire</p>
                <a
                download=""
                href="assets/apk/FoodP222.apk"
                class="button button--flex button--small portfolio_button"
                >
                Application
                <i class="uil uil-arrow-right button_icon"></i>
                </a>
            </div>
            </div>

        </div>

        <div class="swiper-button-next">
            <i class="uil uil-angle-right-b swiper-portfolio-icon"></i>
        </div>
        <div class="swiper-button-prev">
            <i class="uil uil-angle-left-b swiper-portfolio-icon"></i>
        </div>
        <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- PORTFOLIO FIN -->

    <!-- PROJECT -->
    <!-- <section class="project section">
        <div class="project_bg">
        <div class="project_container container grid">
            <div class="project_data">
            <h2 class="project_title">Test</h2>
            <p class="project_description">jqpogj</p>
            <a href="#contact" class="button button--flex button--white">
                Contact Me
                <i class="uil uil-message project_icon button_icon"></i>
            </a>
            </div>

            <img src="assets/img/*" alt="Photo de moi" class="project_img" />
        </div>
        </div>
    </section> -->
    <!-- PROJECT FIN -->

    <!-- CONTACT ME -->
    <section class="contact section" id="contact">
        <h2 class="section_title">Contact</h2>
        <span class="section_subtitle"></span>

        <div class="contact_container container grid">
        <div>
            <div class="contact_informations">
            <i class="uil uil-phone contact_icon"></i>

            <div>
                <h3 class="contact_title">Téléphone :</h3>
                <span class="contact_subtitle">+330671237449</span>
            </div>
            </div>

            <div class="contact_informations">
            <i class="uil uil-envelope contact_icon"></i>

            <div>
                <h3 class="contact_title">Mail pro :</h3>
                <span class="contact_subtitle">leymatnicolaspro@gmail.com</span>
            </div>
            </div>

            <div class="contact_informations">
            <i class="uil uil-map-marker contact_icon"></i>

            <div>
                <h3 class="contact_title">Location :</h3>
                <span class="contact_subtitle">France - 15 Avn. du colonel roche</span>
            </div>
            </div>
        </div>

        <form action="" class="contact_form grid">
            <div class="contact_inputs grid">
            <div class="contact_content">
                <label for="" class="contact_label">Nom</label>
                <input type="text" class="contact_input" />
            </div>

            <div class="contact_content">
                <label for="" class="contact_label">Email</label>
                <input type="email" class="contact_input" />
            </div>
            </div>

            <div class="contact_content">
            <label for="" class="contact_label">Projet</label>
            <input type="text" class="contact_input" />
            </div>
            <div class="contact_content">
            <label for="" class="contact_label">Mesage</label>
            <textarea
                name=""
                id=""
                cols="0"
                rows="7"
                class="contact_input"
            ></textarea>
            </div>
            <div>
            <a href="#" class="button button--flex">
                Envoyé le message
                <i class="uil uil-message button_icon"></i>
            </a>
            </div>
        </form>
        </div>
    </section>
    <!-- CONTACT ME FIN -->
    </main>
    <!-- MAIN FIN -->

    <!-- FOOTER -->
    <footer class="footer">
    <div class="footer_bg">
        <div class="footer_container container grid">
        <div>
            <h1 class="footer_title">Nicolas</h1>
            <span class="footer_subtitle">Développeur</span>
        </div>

        <ul class="footer_links">
            <li>
            <a href="#services" class="footer_link">Services</a>
            </li>

            <li>
            <a href="#portfolio" class="footer_link">Portfolio</a>
            </li>

            <li>
            <a href="#contact" class="footer_link">Contact Me</a>
            </li>
        </ul>

        <div class="footer_socials">
            <a href="" target="_blank" class="footer_social">
            <i class="uil uil-facebook-f"></i>
            </a>
            <a href="" target="_blank" class="footer_social">
            <i class="uil uil-instagram"></i>
            </a>
        </div>
        </div>
        <p class="footer_copy">&#169; Leymat. All rights reserved.</p>
    </div>
    </footer>
    <!-- FOOTER FIN -->

    <!-- SCROLL TOP  -->
    <a href="#" class="scrollup" id="scroll-up">
    <i class="uil uil-arrow-up scrollup_icon"></i>
    </a>
    <!-- SCROLL TOP FIN -->

    <!--  SWIPER JS  -->
    <script src="assets/js/swiper-bundle.min.js"></script>
    <!--  MAIN JS  -->
    <script src="assets/js/main.js"></script>
</body>
</html>
