<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-sklep')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/iao-alert.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

{{--      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>--}}

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('js/iao-alert.jquery.min.js') }}"></script>
    <script type="text/javascript">
        var perfEntries = performance.getEntriesByType("navigation");
        if (perfEntries[0].type === "back_forward") {
            location.reload(true);
        }
    </script>

</head>

<body>
    @include('Components.message')
<div class="containerW shadow">

    <img src="img/baner1.jpg" alt="Nature" class="responsive">

    @include('Components.navbar')

    @yield('content')
</div>

<footer>
    @include('Components.footer')
</footer>
<br>

@yield('modal')

@yield('script')

</body>

</html>
