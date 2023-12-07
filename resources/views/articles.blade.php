@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Artykuły:</h2>
    @if($articles->count() > 0)
    <div class="containerWrap">
            @foreach($articles as $article)
                {{--  <img src="{{ $article->photo }}" alt="">  --}}
                <div class="wrapW">
                    <div class="nazwaTowaru">{{ $article->name }}</div>
                    <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                    {{--  <div class="opisTowaru">{{ $article->description }}</div>  --}}
                    <div class="cena">Cena: {{ number_format($article->price / 100, 2, ',', ' ') }} zł</div>
                    {{--  <div class="dodaj"><a href="#">Dodaj do koszyka</a>&nbsp;
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                    </div>  --}}
                </div>

            @endforeach
    </div>
    @else
        <h3>Brak artykułów</h3>
    @endif
    <div class="addArticle">
        <button class="btnDodaj" onclick="window.location.href='{{ route('createArticles') }}';">Nowy artykuł</a></button>
    </div>

@endsection
