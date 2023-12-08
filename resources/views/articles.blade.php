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
                    <div class="containerButton">
                        <div class="dodaj buttonA"><a href="{{ Route('editArticle', $article->id) }}">Edycja</a>&nbsp;
                            <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i>
                        </div>
                        <div class="dodaj buttonA"><a href="{{ Route('editArticle', $article->id) }}">Usuń</a>&nbsp;
                            <i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>
                        </div>
                    </div>
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
