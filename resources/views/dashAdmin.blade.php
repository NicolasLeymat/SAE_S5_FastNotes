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
              @if (!Auth::user()->isAdmin)
                Erreur 405 Vous n'avez pas accès à cette pasge
              @else
              <div class="items_admin">
                
                <div class="flex_forms">
                  <form action="{{ route('importEleve') }}" class="ajoutEleves flex_form" method="post">
                    @if(session()->has('successOneEleves'))
                    <p>{{ session()->get('successOneEleves') }}</p>
                    @endif
                    @csrf
                    <h3> Ajout élèves via formulaire : </h3>
                    <label for="code">Code : </label></br><input type="text" name="code" id="code" required></br>
                    <label for="identifiant"> Identifiant :</label></br><input type="text" name="identifiant" id="identifiant" required></br>
                    <label for="nom"> Nom : </label></br><input type="text" name="nom" id="nom" required></br>
                    <label for="prenom"> Prenom : </label></br><input type="text" name="prenom" id="prenom" required></br>
                    <label for="email"> Email : </label></br><input type="email" name="email" id="email" required></br>
                    <label for="groupe"> Groupe </br>(Exemple grp B S 5 = inS5_B) : </label></br><input type="text" name="groupe" id="groupe" pattern="^inS[1-6]_[A-Z]$" required></br>
                    <input type="submit" value="Ajouter un élève" class="button button-admin-dash">
                  </form>
                  <form action="{{ route('importEleves') }}" class="ajoutEleves flex_form" method="post">
                    @if(session()->has('successManyEleves'))
                      <p>{{ session()->get('successManyEleves') }}</p>
                    @endif
                    @csrf
                    <h3> Ajout élèves via fichier excel : </h3>
                    <label for="file"> Selectionner un fichier : </label> </br>
                    <input type="file" name="file" id="file"></br>
                    <input type="submit" value="Ajouter des élèves" class="button button-admin-dash">
                  </form>
                </div>
              </div>

              <div class="center">
                <div class="flex_forms">
                  <form action="" class="ajoutEleves flex_form" method="post">
                    @csrf
                    <h3> Ajout évaluation via formulaire : </h3>
                    <label for="code_apogee">Code Apogée : </label></br><input type="text" name="code_apogee" id="code_apogee" required></br>
                    <label for="semestre"> Semestre :</label></br><input type="text" name="semestre" id="semestre" required></br>
                    <label for="libelle"> Nom de l'évaluation : </label></br><input type="text" name="libelle" id="libelle" required></br>
                    <label for="coef"> Coefficient : </label></br><input type="text" name="coef" id="coef" required></br>
                    <label for="type"> Type : </label></br><input type="text" name="type" id="type" list="type_eval" required></br>
                    <datalist id="type_eval">
                      <option value="Ecrit"></option>
                      <option value="Oral"></option>
                      <option value="Compte-rendu"></option>
                      <option value="Travaux Pratiques"></option>
                      <option value="Soutenance"></option>
                      <option value="Memoire"></option>
                      <option value="Projet"></option>
                    </datalist>
                    <input type="submit" value="Ajouter une évaluation" class="button button-admin-dash">
                  </form>
                  <form action="" class="ajoutEleves flex_form">
                    @csrf
                    <h3> Ajout évaluations via fichier excel : </h3>
                    <label for="file"> Selectionner un fichier : </label> </br>
                    <input type="file" name="file" id="file"></br>
                    <input type="submit" value="Ajouter des évaluations" class="button button-admin-dash">
                  </form>
                </div>
              </div>

              <div class="center">
                <form action="" class="exportBulletin flex_items">

                </form>
                <div class="flex_items items_admin"> <p class="text_admin"> Ajouter un/des élèves </p> <a class="button button-admin" href="{{ route('ajoutEleve') }}"> Ajout élève </a></div>
                <div class="flex_items items_admin"> <p class="text_admin"> Ajouter une/des Évaluations </p> <a class="button button-admin" href="{{ route('ajoutEval') }}"> Ajout évaluation </a></div>
                <div class="flex_items items_admin"> <p class="text_admin"> Exporter un bulletin </p> <a class="button button-admin"> Exporter un bulletin </a></div>
              </div>
              @endif
            @endauth
          </div>
        </div>
      </section>
      <!-- HOME FIN -->
    </main>
    <!-- MAIN FIN -->

    <!-- FOOTER -->
    <footer class="footer footer-index">
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
</body>
</html>
