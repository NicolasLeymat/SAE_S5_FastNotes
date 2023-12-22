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

    <title>Liste des élèves</title>
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
        <div class="home_container container grid">
          <div class="home_content">
         
            <table class="prof-tab note-tab">
                <tr>
                    <th>Code élève</th>
                    <th>Groupe</th>
                    <th>Parcours</th>
                    
                </tr>
                @for ($i = 0; $i < count($tabEleves); $i++)
                  <tr class="tab-row tab-row-clear">
                    <td class="tab-cell" >{{ $tabEleves[$i]->code}}</td>
                    <td class="tab-cell "> {{ $listeGroupes[$i]->libelle }} </td>
                    <td class="tab-cell" >{{ $listeGroupes[$i]->parcours }}</td>
                    <td class="tab-cell "><button class="tab-cell clear-cell del-button " onclick="window.location.href='#'">Supprimer </button> </td>
                  </tr>
                @endfor
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
            <a href="" class="footer_link">Leymat Nicolas</a>
            </li>

            <li>
            <a href="" class="footer_link">Mederic Demailly</a>
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
