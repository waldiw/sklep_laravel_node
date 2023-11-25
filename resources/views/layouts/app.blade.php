<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-sklep</title>
    {{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
{{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
</head>
<body>
<div class="containerW shadow">
    <!-- <div class="image"> -->
    <img src="img/baner1.jpg" alt="Nature" class="responsive">
    <!-- </div> -->
    <div class="navbarW sticky">
        @auth

            @include('includes.nav')
        @endauth
            @guest
        <div class="koszyk">
            <a href="">Koszyk</a>&nbsp;
            <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>

        </div>
            @endguest
    </div>
    <div class="opis">

        @yield('content')
{{--        @include('includes.nav')--}}

    </div>

</div>
<footer @auth class="Cend" @endauth>
    @guest
    <div>
        <a href="https://osmolecko.pl">O nas</a>&nbsp;
        <a href="regulamin.html">Regulamin</a>&nbsp;
        <a href="#">Kontakt</a>&nbsp;
        <a href="home.html">Sklep</a>&nbsp;
    </div>
    @endguest
    <div><i class="fa-regular fa-copyright"></i>&nbsp;OSM Olecko</div>
</footer>
<br>

@auth
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endauth
</body>
</html>
