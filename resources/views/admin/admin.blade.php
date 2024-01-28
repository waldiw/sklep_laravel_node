@extends('layouts.app')
@section('title', 'E-sklep Administracja')
@section('content')
    <h2>Ustawienia:</h2>
    <div class="article">
        <form method="post" action="{{ route('adminUpdate', $param->id) }}" enctype="multipart/form-data">
            @csrf

            {{ method_field('PUT') }}

            <div class="form-field">
                <label for="account" class="articleFormLabel">Numer konta:</label>
                <input id="account" class="form-field @error('account') is-invalid error @enderror" value="{{ $param->account }}" type="text" name="account" placeholder="Numer konta">
            </div>

              <div class="">
                <label for="shipping" class="articleFormLabel">Koszt wysyłki:</label>
                <input id="shipping" class="@error('shipping') is-invalid error @enderror" value="{{ number_format($param->shipping / 100, 2, ',', ' ') }}" type="text" name="shipping" placeholder="00,00">
            </div>
            <div>
                <label for="email" class="articleFormLabel">Adres e-mail do wysyłania potwierdzenia:</label>
                <input id="email" type="text" class=" @error('email') is-invalid error @enderror" name="email" value="{{ $param->email }}" >
            </div>
            <div class="btnAddArticle">
                <button type="submit" class="btnDodaj">Zapisz ustawienia <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
            </div>
        </form>
    </div>

@endsection
