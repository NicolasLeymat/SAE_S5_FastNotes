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
        <div class="home_container container grid">
          <div class="home_content">
          @csrf
            <b class="semestre-m"> <p>Moyenne du Semestre :</p>
            @if($moyenneSemestre < 10)
              <p style="color:red">{{ $moyenneSemestre }}</p>
            @endif
            @if($moyenneSemestre >= 10 && $moyenneSemestre < 15)
              <p style="color:orange">{{ $moyenneSemestre }}</p>
            @endif
            @if($moyenneSemestre >= 15)
              <p style="color:green">{{ $moyenneSemestre }}</p>
            @endif
            </b>             
            <table class="table-moyenne" >
              @foreach ($tabMoyennesCompetences as $key => $valeur)
              <tr class="tab-row tab-row-dark">
                <td class="tab-cell"><b>{{ $key }}</b></td>
                @if ($valeur==="Pas disponible")
                  <td style="color:red" 
                @elseif($valeur < 10)
                <td style="color:red" 
                @elseif($valeur > 10 && $valeur < 15)
                <td style="color:orange" 
                @else
                <td style="color:green"
                @endif
                @if ($valeur =="Pas disponible")
                  class="tab-cell">{{ $valeur }}</td>
                @else
                  class="tab-cell">{{ round($valeur,2) }}</td>
                @endif
              </tr>
              @endforeach
            </table>

            <table class="note-tab">
                @foreach ($tabMoyennesRessources as $key => $valeur)
                  <tr class="tab-row tab-row-dark">
                    <td class="tab-cell" ><b>{{ $valeur[1] }}</b></td>
                    <td class="tab-cell"></td>
                    <td class="tab-cell centered-cell"> 
                      @if($valeur[0] == "Pas disponible") 
                        <p style="color:red">
                      @elseif($valeur[0] < 10)
                        <p style="color:red">
                      @elseif($valeur[0] >= 10 && $valeur[0] < 15) 
                        <p style="color:orange">
                      @else($valeur[0] >= 15) 
                        <p style="color:green">
                      @endif 
                      @if ($valeur[0] != "Pas disponible")
                      {{ round($valeur[0],2) }} 
                      @else 
                      {{ $valeur[0] }} </p>
                      @endif
                      </td>
                  </tr>
                  @foreach ($evaluations as $evaluation)
                    @if ($evaluation['code_ressource'] == $key)
                      <tr class="tab-row tab-row-clear">
                        <td class="tab-cell"> {{ $evaluation->libelle }} </td>
                        <td class="tab-cell"> {{ $evaluation->type }} </td>
                        @php
                          $a = false;
                        @endphp
                        @foreach($tabNotes as $note )
                          @if($note->id == $evaluation->id)
                            @if($note->pivot->note < 10)
                              <td style="color:red"  class="tab-cell centered-cell">{{ $note->pivot->note }}</td>
                            @endif
                            @if($note->pivot->note > 10 && $note->pivot->note < 15)
                              <td style="color:orange"  class="tab-cell centered-cell">{{ $note->pivot->note }}</td>
                            @endif
                            @if($note->pivot->note > 15)
                              <td style="color:green" class="tab-cell centered-cell" >{{ $note->pivot->note }}</td>
                            @endif
                            @php $a = true; @endphp
                          @endif
                        @endforeach
                        @if ($a != true)
                          <td style="color:red" class="tab-cell centered-cell" > Pas disponible </td>
                        @endif
                      </tr>
                    @endif
                  @endforeach
                @endforeach
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
