@extends('layouts.app')

@section('title', 'E-sklep Edycja')

{{--@php dd($errors) @endphp--}}
@section('content')
    <h2>Edycja artykułu:</h2>
    <div class="article">
    <form method="post" action="{{ Route('editArticle', $article->id) }}" enctype="multipart/form-data">
    @csrf

        {{ method_field('PUT') }}

        <div class="form-field">
            <input class="form-field @error('name') is-invalid error @enderror" value="{{ $article->name }}" type="text" name="name" placeholder="Nazwa artykułu">
        </div>

        <div class="">
            <label class="articleFormLabel">Obraz:</label>
            <input type="file" name="image">
        </div>

        <div class="">
        <label class="articleFormLabel">Opis:</label>
            <textarea class="articleContent @error('description') is-invalid error @enderror" name="description" placeholder="Opis">{{ $article->description }}</textarea>
        </div>
        <div class="">
        <label class="articleFormLabel">Cena zł:</label>
            <input class="@error('price') is-invalid error @enderror" value="{{ number_format($article->price / 100, 2, ',', ' ') }}" type="text" name="price" placeholder="00,00">
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Zmień artykuł <i class="fa-solid fa-repeat" style="color: #ffffff;"></i></button>
        </div>
    </form>
    </div>
@endsection
