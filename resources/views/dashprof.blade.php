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
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}" />
    <!--  CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>Notes Iut</title>
</head>
<body>
    <!--  HEADER  -->
    <header class="header" id="header">
    <nav class="nav container">
        <a href="#" class="nav_logo"
        >Fast <br />
        Notes</a
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
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($evals as $evaluation)
                    <a href="{{ route('evaluations') }}" class="">
                    <tr>
                        <td>{{evaluation -> libelle}}</td>
                        <td>{{ evaluation -> type }}</td>
                    </tr>
                    </a>
                    @endforeach
                </tbody>
            </table>

        </div>
        </div>
    </section>
    <!-- HOME FIN -->
    </main>
    <!-- MAIN FIN -->

    <!-- FOOTER -->
    <footer class="footer">
    <div class="footer_bg">
        <div class="footer_container container grid">
        <div>
            <h1 class="footer_title">Fast</h1>
            <span class="footer_subtitle">Notes</span>
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
    <script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
    <!--  MAIN JS  -->
    <script src="{{asset('assets/js/main.js')}}"></script>
</body>
</html>
