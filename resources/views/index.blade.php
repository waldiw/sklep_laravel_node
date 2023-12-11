<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sklep</title>
{{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>


</head>

<body>
<div class="containerW shadow">
    <!-- <div class="image"> -->
    <img src="img/baner1.jpg" alt="Nature" class="responsive">
    <!-- </div> -->
    <div class="navbarW sticky">
        <div class="koszyk">
            <a href="">Koszyk</a>&nbsp;
            <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
        </div>
    </div>
    <div class="opis">
        <h1>Cukierki Krówka</h1>
        Kremowe cukierki Krówka produkowane według tradycyjnej receptury bez użycia maszyn przemysłowych, formowane
        i zawijane ręcznie. Chcąc zachować ciągnący charakter cukierka należ przechowywać go w lodówce. Cukierki
        przechowywane w temperaturze pokojowej po pewnym czsie stają się kruche. Oprócz zawijania w tradycyjne
        papierki oferujemy usługę konfekcjonowania cukierków w papierki reklamowe zamawiającego. Stanowią one wtedy
        doskonały element reklamowy firmy lub uroczystości okolicznościowej. Aby dowiedzieć się więcej skontaktuj
        się z nami.
        <br>Skład: cukier, syrop glukozowy, śmietanka 16%, mleko w proszku.
    </div>
    <div class="containerWrap">

        @if($articles->count() > 0)
        <div class="containerWrap">
            @foreach($articles as $article)
                {{--  <img src="{{ $article->photo }}" alt="">  --}}
                <div class="wrapW articleDetails">
                    <div class="nazwaTowaru">{{ $article->name }}</div>
                    <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                    {{--  <div class="opisTowaru">{{ $article->description }}</div>  --}}
                    <div class="cena">Cena: {{ number_format($article->price / 100, 2, ',', ' ') }} zł</div>
                    {{--  <div class="dodaj"><a href="#">Dodaj do koszyka</a>&nbsp;
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                    </div>  --}}
                    <button class="btnAddCart" onclick="window.location.href='';">Dodaj do koszyka <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></button>
                    {{--  <div class="containerButton">
                        
                        <button class="btnDodaj buttonA" onclick="window.location.href='{{ route('editArticle', $article->id) }}';">Edytuj <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                        <form method="post" action="{{ Route('deleteArticle', $article->id) }}">
                            @csrf
                            {{ method_field('DELETE') }}
                            <button class="btnDelete buttonA" onclick="return confirm('Usunąć artykuł?')">Usuń <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                        </form>

                    </div>  --}}
                </div>

            @endforeach
    </div>
    @else
        <h3>Brak artykułów</h3>
    @endif


        {{--  <div class="wrapW">
            <div class="foto"><img src="img/art1_160.jpg" alt="Cukierki" class="responsive"></div>
            <div class="opisTowaru">Cukierki Krówka pakowane hermetycznie</div>
            <div class="cena">Cena: 35,00 zł</div>
            <div class="dodaj"><a href="#">Dodaj do koszyka</a>&nbsp;
                <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
            </div>
        </div>  --}}

 
    </div>
</div>


<footer>
    <div>
        <a href="https://osmolecko.pl">O nas</a>&nbsp;
        <a href="regulamin.html">Regulamin</a>&nbsp;
        <a href="#">Kontakt</a>&nbsp;
        <a href="home.html">Sklep</a>&nbsp;
    </div>
    <div><i class="fa-regular fa-copyright"></i>&nbsp;OSM Olecko</div>
</footer>
<br>


</body>

</html>
