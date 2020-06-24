<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/mix-manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">

    <nav class="navbar navbar-primary navbar-expand-md">

        <label for="menu-btn" class="navbar-burger-btn navbar-burger-icon"></label>
        <input type="checkbox" id="menu-btn" class="navbar-burger-btn">

        <button type="button" aria-label="Toggle navigation" class="navbar-toggler collapsed" aria-expanded="false"
                aria-controls="nav-collapse"><span class="navbar-toggler-icon"></span></button>
        <div class="navbar-brand">
            <a class="nav-item" href="{{ route('welcome') }}">
                <img src="{{asset('img/Logo.png')}}" width="130" height="50">
            </a>
        </div>
        {{--        <div id="nav-collapse" class="navbar-collapse collapse" style="display: none;">--}}
        <ul class="navbar-collapse navbar-nav">
            @auth
                <li class="nav-item ">
                    <a href="{{ route('home') }}"
                       class="nav-link nav-item {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>
                </li>
                <li class="nav-item b-nav-dropdown dropdown " left="">
                    <a role="button" aria-haspopup="true" aria-expanded="false"
                       class="nav-link dropdown-toggle {{ request()->routeIs('actor.index') || request()->routeIs('actor.create') || request()->routeIs('actor.search') ? 'is-active' : '' }}"
                       href="#">
                        <span>Actors</span>
                    </a>
                    <ul tabindex="-1" class="dropdown-menu">
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem"
                               class="nav-item dropdown-item {{ request()->routeIs('actor.index') ? 'is-active' : '' }}"
                               href="{{ route('actor.index') }}">
                                List
                            </a>
                        </li>
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem"
                               class="nav-item dropdown-item {{ request()->routeIs('actor.create') ? 'is-active' : '' }}"
                               href="{{ route('actor.create') }}">
                                Create
                            </a>
                        </li>
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem"
                               class="nav-item dropdown-item {{ request()->routeIs('actor.search') ? 'is-active' : '' }}"
                               href="{{ route('actor.search') }}">
                                Search
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item b-nav-dropdown dropdown" left="">
                    <a role="button" aria-haspopup="true" aria-expanded="false"
                       class="nav-link dropdown-toggle {{ request()->routeIs('film.index') || request()->routeIs('film.create') ? 'is-active' : '' }}"
                       href="#">
                        <span>Films</span>
                    </a>
                    <ul tabindex="-1" class="dropdown-menu">
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem"
                               class="nav-item dropdown-item {{ request()->routeIs('film.index') ? 'is-active' : '' }}"
                               href="{{ route('film.index') }}">
                                List
                            </a>
                        </li>
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem"
                               class="nav-item dropdown-item {{ request()->routeIs('film.create') ? 'is-active' : '' }}"
                               href="{{ route('film.create') }}">
                                Create
                            </a>
                        </li>
                    </ul>
                </li>
            @endauth
        </ul>
        <ul class="navbar-collapse navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <div class="btn">
                        <a class="btn btn-primary" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="btn btn-light" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    </div>
                </li>
            @else
                <li class="nav-item b-nav-dropdown dropdown ml-auto">
                    <a role="button" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"
                       href="#">
                        <span> {{ Auth::user()->name }} </span>
                    </a>
                    <ul tabindex="-1" class="dropdown-menu dropdown-menu-right">
                        <li role="presentation" class="nav-item dropdown-item">
                            <a role="menuitem" class="nav-item dropdown-item" href="#"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </a>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
        {{--        </div>--}}
    </nav>


    <div class="main is-fullheight">
        @yield('content')
    </div>


    <footer class="footer">
        <div class="content text-center">
            <small>Unknown Films BIC4 IE <b>::</b> Bretschneider – Ivkic – Rappl</small>
        </div>
    </footer>
</div>
</body>
</html>
