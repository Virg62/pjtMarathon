<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seeries - @yield('title')</title>
    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
    <!--
        <a href="{{ url('/') }}">
            {{ config('app.name', 'Seeries') }}
        </a>
-->
        <a href="{{ url('/') }}">
            <img src="{{ url('img/logo_blanc.png') }}" id="logo" alt="logo">
        </a>

    </div>

</header>
<!-- Authentication Links -->
<nav class="container">
    <ul class="menu">
        @if (isset($genres))
            <li>
                <form action="{{ route('serie.sort') }}" method="get">
                    <select name='genre'>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id}}">{{ $genre->nom }}</option>
                        @endforeach
                    </select>
                    <input type="submit" value="Ok">
                </form>
            </li>
            <li class="recherche">
                <form action="{{ route('serie.sort') }}" method="get">
                    <input type="text" name="saisie" placeholder="Recherche">
                    <button type="submit" style="border: none; background-color: transparent; cursor: pointer;"><img src="{{ url('img/loupe.png') }}" alt=""></button>
                </form>
            </li>
        @endif
        @guest
            <li><a href="{{ route('register') }}">S'inscrire</a></li>
            <li><a href="{{ route('login') }}">Se connecter</a></li>
        @else
            <li style="color:#115557;"> Bonjour <a href ="{{ route('user.home') }}">{{ Auth::user()->name }}</a></li>
            <li><a href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    Déconnexion
                </a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        @endguest
    </ul>
</nav>

<div id="main">
    <div class="container categories">
        @yield('content')
    </div>

</div>

@section('footer')
<footer>

</footer>
@endsection
<!-- Scripts -->
<script src="{{ asset('js/jquery.js') }}"></script>
</body>
</html>
