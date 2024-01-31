@extends('layouts.app')

@section('title', 'E-sklep Edycja')

{{--@php dd($errors) @endphp--}}
@section('content')
    <h2>Edycja metody płatności:</h2>
    <div class="article">
    <form method="post" action="{{ Route('editShipping', $shipping->id) }}" enctype="multipart/form-data">
    @csrf

        {{ method_field('PUT') }}

        <div class="form-field">
            <input class="form-field @error('name') is-invalid error @enderror" value="{{ $shipping->name }}" type="text" name="name" placeholder="Nazwa metody płatności">
        </div>

             <div class="">
        <label class="articleFormLabel">Cena zł:</label>
            <input class="@error('shipping') is-invalid error @enderror" value="{{ number_format($shipping->shipping / 100, 2, ',', ' ') }}" type="text" name="shipping" placeholder="00,00">
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Zmień metodę płatności <i class="fa-solid fa-repeat" style="color: #ffffff;"></i></button>
        </div>
    </form>
    </div>
@endsection
