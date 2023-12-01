@extends('layouts.app')

@section('content')
    <h2>Dodaj artykuł:</h2>
    <div class="article">
    <form method="post" action="{{ route('createArticles') }}">
    @csrf
        <div class="form-field">
            <input class="form-field{{ $errors->has('title') ? ' is-invalid' : '' }}" type="text" name="name" placeholder="Nazwa artykułu">
        </div>
        
        <div class="">
            <label class="articleFormLabel">Obraz:</label>
            <input type="file" name="image">
        </div>

        <div class="">
        <label class="articleFormLabel">Opis:</label>
            <textarea class="articleContent" name="description" placeholder="Opis"></textarea>
        </div>
        <div class="">
        <label class="articleFormLabel">Cena zł:</label>
            <input type="text" name="price" placeholder="00,00">
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Dodaj artykuł</button>
        </div>
    </form>
    </div>
@endsection