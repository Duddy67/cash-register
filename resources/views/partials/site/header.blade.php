<nav class="navbar navbar-expand-md navbar-light bg-light">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
          <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Accueil</a></li>
          <li class="nav-item"><a href="{{ url('/operations') }}" class="nav-link">Opérations</a></li>
            @auth
                <li class="nav-item"><a href="{{ url('/operations/create') }}" class="nav-link">Créé une opération</a></li>
            @endauth
      </ul>
      </div>

  @if (Route::has('login'))
      <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
   @auth
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
   @else
       <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

       @if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
       @endif
   @endauth
      </div>
   @endif
</nav>

