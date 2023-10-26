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

    <script>
        function confirmerSaisie(){
            var nbNotes = 0;
            var nbNotesNonSaisies = 0;
            var inputElements = document.querySelectorAll('input[type="number"]');
            inputElements.forEach(function(inputElement) {
                nbNotes+=1;
                if (inputElement.value === "") {
                    nbNotesNonSaisies+=1;
                }
            });

            if (nbNotes==nbNotesNonSaisies) {
                document.getElementById('formulaireNotes').submit();
            } else if(nbNotesNonSaisies>1){
                if(confirm(nbNotesNonSaisies+' notes n\'ont pas été saisies. Voulez-vous tout de même enregistrer les notes saisies ?')){
                    document.getElementById('formulaireNotes').submit();
                }
            } else {
                if(confirm(nbNotesNonSaisies+' note n\'a pas été saisie. Voulez-vous tout de même enregistrer les notes saisies ?')){
                    document.getElementById('formulaireNotes').submit();
                }
            }
        }
    </script>
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
        <div class="home_content grid">
        <form action="{{ route('saisir_notes') }}" method="POST" name="formulaire" id="formulaireNotes">
            @csrf
            <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}"> 
            <table>
                <thead>
                    <tr>
                        <th>Numéro étudiant</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Note</th>
                    </tr>
                </thead>
            @foreach($eleves as $eleve)
                <tr>
                    <td>{{$eleve['identification']}}</td>
                    <td>{{$eleve['nom']}}</td>
                    <td>{{$eleve['prenom']}}</td>
                    <td><input type="number" step="0.001" name="notes[{{ $eleve['code'] }}][note]" value="{{ $eleve['note'] }}" min= 0 max=20></td>
                </tr>
            @endforeach
            </table>
            <input type="button" value="Enregistrer les notes" onclick='confirmerSaisie()'>
        </form>
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
</body>
</html>
