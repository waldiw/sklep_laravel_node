@extends('layouts.app')

@section('title', 'E-sklep Edycja')

@section('content')
    <h2>Edycja artykułu:</h2>
    <div class="article">
        <form method="post" action="{{ Route('editArticle', $article->id) }}" enctype="multipart/form-data">
            @csrf

            {{ method_field('PUT') }}

            <div class="form-field">
                <input class="form-field @error('name') is-invalid error @enderror" value="{{ $article->name }}"
                       type="text" name="name" placeholder="Nazwa artykułu">
            </div>
            <div class="">
                <label class="articleFormLabel">Obraz:</label>
                <input type="file" name="image">
            </div>
            <div class="">
                <label for="description" class="articleFormLabel">Opis:</label>
                <textarea id="description" class="articleContent @error('description') is-invalid error @enderror"
                          name="description" placeholder="Opis">{{ $article->description }}</textarea>
            </div>
            <div class="">
                <label for="price" class="articleFormLabel">Cena zł:</label>
                <input id="price" class="@error('price') is-invalid error @enderror"
                       value="{{ number_format($article->price / 100, 2, ',', ' ') }}" type="text" name="price"
                       placeholder="00,00">
            </div>
            <div class="checkActive">
                <input type="checkbox" id="checkActive" name="active"
                       value="1" {{ $article->active === 1 ? 'checked' : '' }}/>
                <label for="checkActive"> Aktywny</label>
            </div>
            <div class="btnAddArticle">
                <button type="submit" class="btnDodaj">Zmień artykuł <i class="fa-solid fa-repeat"
                                                                        style="color: #ffffff;"></i></button>
            </div>
        </form>
    </div>
@endsection
