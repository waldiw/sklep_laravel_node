@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Artykuły:</h2>
    @if($articles->count() > 0)
            @foreach($articles as $article)
                <img src="{{ $article->photo }}" alt="">

            @endforeach
    @else
        <h3>Brak artykułów</h3>
    @endif
    <div class="addArticle">
        <button class="btnDodaj" onclick="window.location.href='{{ route('createArticles') }}';">Nowy artykuł</a></button>
    </div>

@endsection
