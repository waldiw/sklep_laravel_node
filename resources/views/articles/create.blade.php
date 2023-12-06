@extends('layouts.app')

@section('title', 'E-sklep Administracja')

{{--@php dd($errors) @endphp--}}
@section('content')
    <h2>Dodaj artykuł:</h2>
    <div class="article">
    <form method="post" action="{{ route('createArticles') }}" enctype="multipart/form-data">
    @csrf
        <div class="form-field">
            <input class="form-field @error('name') is-invalid error @enderror" value="{{ old('name') }}" type="text" name="name" placeholder="Nazwa artykułu">
        </div>
        
        <div class="">
            <label class="articleFormLabel">Obraz:</label>
            <input type="file" name="image">
        </div>

        <div class="">
        <label class="articleFormLabel">Opis:</label>
            <textarea class="articleContent @error('description') is-invalid error @enderror" name="description" placeholder="Opis">{{ old('description') }}</textarea>
        </div>
        <div class="">
        <label class="articleFormLabel">Cena zł:</label>
            <input class="@error('price') is-invalid error @enderror" value="{{ old('price') }}" type="text" name="price" placeholder="00,00">
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Dodaj artykuł</button>
        </div>
    </form>
    </div>
@endsection
