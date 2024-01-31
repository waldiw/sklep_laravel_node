@extends('layouts.app')

@section('title', 'E-sklep Dodaj')

{{--@php dd($errors) @endphp--}}
@section('content')
    <h2>Dodaj metodę płatności:</h2>
    <div class="article">
    <form method="post" action="{{ route('createShipping') }}" enctype="multipart/form-data">
    @csrf
        <div class="form-field">
            <input class="form-field @error('name') is-invalid error @enderror" value="{{ old('name') }}" type="text" name="name" placeholder="Nazwa metody płatności">
        </div>

        <div class="">
        <label for="shipping" class="">Koszt wysyłki zł:</label>
            <input id="shipping" class="@error('shipping') is-invalid error @enderror" value="{{ old('shipping') }}" type="text" name="shipping" placeholder="00,00">
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Dodaj metodę płatności <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
        </div>
    </form>
    </div>
@endsection
