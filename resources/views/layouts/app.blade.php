<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Home')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/font-awesome@4.7.0/css/font-awesome.min.css">
    @stack('css')
</head>
<body class="d-flex flex-column h-100">

<header>
    <nav class="app-header navbar navbar-expand-lg fixed-top navbar-dark bg-mbs">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fa fa-commenting" aria-hidden="true"></i>&nbsp;{{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/mbs"><i class="fa fa-commenting-o" aria-hidden="true"></i> Broadcast Messaging</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/company/member"><i class="fa fa-users" aria-hidden="true"></i> List of Members</a>
                    </li>
                </ul>

                <ul class="navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fa fa-sign-in" aria-hidden="true"></i> {{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="fa fa-user" aria-hidden="true"></i> {{ __('Register') }}
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user" aria-hidden="true"></i> {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>

<main role="main" class="flex-shrink-0 mt-3">
    <div class="container">
        @yield('content')
    </div>
</main>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
        <a target="_blank" href="https://github.com/rph-dev/mbs">RPH Linetify</a>
        <span>© 2019 RPH.</span><br>
        <span>Powered by</span>
        <a target="_blank" href="http://rph.co.th">RPH</a>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>
@stack('js')
</body>
</html>
