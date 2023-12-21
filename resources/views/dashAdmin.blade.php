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
        <a href="{{ route('index') }}" class="nav_logo"
        >Fast <br />
        Notes</a
        >
        <div class="nav_menu" id="nav-menu">
        <ul class="nav_list grid">
          @auth 
          <li class="nav_item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                  onclick="event.preventDefault();
                    this.closest('form').submit();">
                <p class="nav_link">{{ __('Se déconnecter') }}</p>
              </x-dropdown-link>
            </form>
          </li>
            @else
              <li class="nav_item">
              <a href="{{ route('login') }}" class="nav_link">
                  <i class="uil uil-message nav_icon"></i> Log in
              </a>
              </li>
            @endauth
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
        <div class="home_container container full_home">
          <div class="home_content full_home center">
            @auth
              <div class="items_admin flex_forms">
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des années</p> <br>
                  <a class="tab-cell button button-admins">Afficher les années</a><br>
                  <a class="tab-cell button button-admins">Ajouter une années</a><br>
                  <a class="tab-cell button button-admins">Ajouter des années</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des semestres</p> <br>
                  <a class="tab-cell button button-admins">Afficher les semestres</a><br>
                  <a class="tab-cell button button-admins">Ajouter un semestre</a><br>
                  <a class="tab-cell button button-admins">Ajouter des semestres</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des parcours</p> <br>
                  <a class="tab-cell button button-admins">Afficher les parcours</a><br>
                  <a class="tab-cell button button-admins">Ajouter un parcour</a><br>
                  <a class="tab-cell button button-admins">Ajouter des parcours</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des groupes</p> <br>
                  <a class="tab-cell button button-admins">Afficher les groupes</a><br>
                  <a class="tab-cell button button-admins">Ajouter un groupe</a><br>
                  <a class="tab-cell button button-admins">Ajouter de groupes</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des élèves</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherEleves') }}">Afficher les élèves</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEleve') }}">Ajouter un élève</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEleve') }}">Ajouter des élèves</a>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des UE</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('ue.index') }}">Afficher les UE</a><br>
                  <a class="tab-cell button button-admins">Ajouter une UE</a><br>
                  <a class="tab-cell button button-admins">Ajouter des UE</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des ressources</p> <br>
                  <a class="tab-cell button button-admins">Afficher les ressources</a><br>
                  <a class="tab-cell button button-admins">Ajouter une ressource</a><br>
                  <a class="tab-cell button button-admins">Ajouter des ressources</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des évaluations</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('afficherEvals') }}">Afficher les évaluations</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEval') }}">Ajouter une évaluations</a><br>
                  <a class="tab-cell button button-admins" href="{{ route('ajoutEval') }}">Ajouter des évaluations</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des profésseurs</p> <br>
                  <a class="tab-cell button button-admins" href="{{ route('profs.index') }}">Afficher les profésseurs</a><br>
                  <a class="tab-cell button button-admins">Ajouter un profésseur</a><br>
                  <a class="tab-cell button button-admins">Ajouter des profésseurs</a><br>
                </div>
                <div class="flex_divs">
                  <p style="margin-top:10px;">Gestion des enseignements</p> <br>
                  <a class="tab-cell button button-admins">Afficher les enseignements</a><br>
                  <a class="tab-cell button button-admins">Ajouter un enseignement</a><br>
                  <a class="tab-cell button button-admins">Ajouter des enseignements</a><br>
                </div>
              </div>
            @endauth
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
            <a href="" class="footer_link">Leymat Nicolas</a>
            </li>

            <li>
            <a href="" class="footer_link">Mederic Damailly</a>
            </li>

            <li>
            <a href="" class="footer_link">Noa Despaux</a>
            </li>

            <li>
            <a href="" class="footer_link">David Pacuraru</a>
            </li>

            <li>
            <a href="" class="footer_link">Lucas Veslin</a>
            </li>

            <li>
            <a href="" class="footer_link">Louis Camborieux</a>
            </li>
        </ul>
        </div>
        <p class="footer_copy">&#169; Code F. All rights reserved.</p>
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
    <script src="{{ asset('js/app.js') }}"></script>


    <form method="post" action="{{ route('afficherEleves') }}">
    @csrf
      <button type="submit">Afficher la liste des élèves</button>
    </form>

    <form method="post" action="{{ route('afficherEvals') }}">
    @csrf
      <button type="submit">Afficher la liste des évaluations</button>
    </form>


</body>
</html>
