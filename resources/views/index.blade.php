{{--  <!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sklep</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/iao-alert.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="{{ asset('js/iao-alert.jquery.min.js') }}"></script>

</head>

<body>
<div class="containerW shadow">

    <img src="img/baner1.jpg" alt="Nature" class="responsive">

    @include('Components.navbar')  --}}
    @extends('layouts.shop')

    @section('title', 'E-sklep Koszyk')
    
    @section('content')

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
                    @if($article->category === \App\Enums\Category::CUKIERKI)
                    <div class="wrapW articleDetails">
                        <div id="{{ $article->id }}" data-article="{{ route('showArticle', $article->id) }}"
                             class="showArticle">
                            <input type="hidden" class="productId" value="{{ $article->id }}">
                            <div class="content">
                                <div class="upper">
                                    <div class="nazwaTowaru">{{ $article->name }}</div>
                                    <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                                </div>
                                <div class="bottom">
                                    <div class="cena">Cena: {{ numberFormat($article->price) }} zł</div>
                                </div>
                            </div>
                        </div>
                        <button class="btnAddCart" onclick="">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"
                                                                                  style="color: #ffffff;"></i></button>
                    </div>
                    @endif
                @endforeach
                <div class="wrapW cReklam">
                    <div class="nazwaTowaru">Cukierki Krówka reklamowe</div>
                    <div class="foto"><img src="img/cukierki_reklamowe.jpg" alt="Cukierki" class="responsive"></div>
                    <div class="opisTowaru">Cukierki Krówka zawijane w papierki z logo zamawiającego.<br>Zachęcamy do kontaktu.
                    </div>
                    <button class="btnContact" onclick="location.href = '{{ route('showContact') }}'">Kntakt z nami</button>
                </div>
            </div>
        @else
            <h3>Brak artykułów</h3>
        @endif

    </div>

    <div class="opis">
        <h1>Inne artykuły</h1>
    </div>
    <div class="containerWrap">
        @if($articles->count() > 0)
            <div class="containerWrap">
                @foreach($articles as $article)
                    @if($article->category === \App\Enums\Category::INNE)
                        <div class="wrapW articleDetails">
                            <div id="{{ $article->id }}" data-article="{{ route('showArticle', $article->id) }}"
                                 class="showArticle">
                                <input type="hidden" class="productId" value="{{ $article->id }}">
                                <div class="content">
                                    <div class="upper">
                                        <div class="nazwaTowaru">{{ $article->name }}</div>
                                        <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                                    </div>
                                    <div class="bottom">
                                        <div class="cena">Cena: {{ numberFormat($article->price) }} zł</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btnAddCart" onclick="">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"></i></button>
                        </div>

                    @endif
                @endforeach
            </div>
        @else
            <h3>Brak artykułów</h3>
        @endif
    </div>
</div>

@endsection

@section('modal')
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modalContent articleDetails">
        <div class="modalHeader">
            <div id="modalPhoto" class="modalPhoto"></div>
            <div id="articleName"></div>
            <span class="close">&times;</span>
        </div>
        <div class="modalBody">
            <input id="articleId" type="hidden" class="productId" value="5">
            <p id="articleDescription"></p>
            <div id="articlePrice" class="cena"></div>
        </div>
        <div class="modalFooter">
            <button class="btnAddCart">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"
                                                           style="color: #ffffff;"></i></button>
        </div>
    </div>
</div>
@endsection

<script src="{{ asset('js/cookies.js') }}"></script>

@section('script')
    @include('scripts.shop')
@endsection