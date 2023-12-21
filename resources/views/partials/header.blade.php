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