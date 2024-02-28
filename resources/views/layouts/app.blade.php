<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'E-sklep')</title>
    {{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


{{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
</head>
<body>
@include('Components.message')
<div class="containerW shadow">
    
    <img src=" {{asset('img/baner1.jpg') }}" alt="Nature" class="responsive">
    
    <div class="navbarW sticky">
        @auth

            @include('includes.nav')
        @endauth
            @guest
        <div class="koszyk">
            <a href="{{ route('cart') }}">Koszyk</a>&nbsp;
            <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>

        </div>
            @endguest
    </div>
    <div class="opis">

        @yield('content')


    </div>

</div>
<footer @auth class="Cend" @endauth>
    @guest
        @include('Components.footer')
    @endguest
    @auth
        <div><i class="fa-regular fa-copyright"></i>&nbsp;OSM Olecko</div>
    @endauth
</footer>
<br>

@auth
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endauth

@yield('script')

</body>
</html>
