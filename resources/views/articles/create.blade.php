@extends('layouts.app')

@section('title', 'E-sklep Dodaj')

@section('content')
    <h2>Dodaj artykuł:</h2>
    <div class="article">
        <form method="post" action="{{ route('createArticle') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-field">
                <input class="form-field @error('name') is-invalid error @enderror" value="{{ old('name') }}"
                       type="text" name="name" placeholder="Nazwa artykułu">
            </div>
            <div class="">
                <label class="articleFormLabel">Obraz:</label>
                <input type="file" name="image">
            </div>
            <div class="">
                <label for="articleContent" class="articleFormLabel">Opis:</label>
                <textarea id="articleContent" class="articleContent @error('description') is-invalid error @enderror"
                          name="description" placeholder="Opis">{{ old('description') }}</textarea>
            </div>
            <div class="">
                <label for="price" class="articleFormLabel">Cena zł:</label>
                <input id="price" class="@error('price') is-invalid error @enderror" value="{{ old('price') }}"
                       type="text" name="price" placeholder="00,00">
            </div>
            <div id="typeSelect" class="form-select{{ $errors->has('category') ? ' is-invalid' : '' }}">
                <label for="category" class="articleFormLabel">Kategoria:</label>
                <select id="category" name="category">
                    <option value="" disabled selected>Wybierz kategorię</option>
                    @foreach(\App\Enums\Category::CATEGORY as $category)
                        <option value="{{ $category }}" @selected(old('category') == $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div class="checkActive">
                <input type="checkbox" id="checkActive" name="active" value="1" {{ old('active') ? 'checked' : '' }}/>
                <label for="checkActive"> Aktywny</label>
            </div>
            <div class="btnAddArticle">
                <button type="submit" class="btnDodaj">Dodaj artykuł <i class="fa-regular fa-square-plus"
                                                                        style="color: #ffffff;"></i></button>
            </div>
        </form>
    </div>
@endsection
