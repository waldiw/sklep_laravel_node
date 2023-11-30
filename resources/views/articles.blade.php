@extends('layouts.app')

@section('content')
    <h2>Artkuły:</h2>
    @if($articles->count() > 0)

    @else
        <h3>Brak artykułów</h3>
    @endif
    <div class="addArticle">
        <div class="dodaj"><a href="{{ route('createArticles') }}">Nowy artykuł</a></div>
    </div>
@endsection
