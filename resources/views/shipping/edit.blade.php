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
        <label for="shipping" class="articleFormLabel">Cena zł:</label>
            <input id="shipping" class="@error('shipping') is-invalid error @enderror" value="{{ number_format($shipping->shipping / 100, 2, ',', ' ') }}" type="text" name="shipping" placeholder="00,00">
        </div>
        <div class="{{ $errors->has('type') ? ' is-invalid' : '' }}">
            <label for="type" class="articleFormLabel">Typ płatności:</label>
            <select id="type" name="type">
                <option value="" disabled>Wybierz typ</option>
                @foreach(\App\Enums\ShippingType::TYPES as $type)
                    <option value="{{ $type }}"{{ $shipping->type === $type ? ' selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
            <div class="checkActive">
                <input type="checkbox" id="checkActive" name="active" value="1" {{ $shipping->active === 1 ? 'checked' : '' }}/>
                <label for="checkActive"> Aktywny</label>
            </div>
        </div>
        <div class="btnAddArticle">
            <button type="submit" class="btnDodaj">Zmień metodę płatności <i class="fa-solid fa-repeat" style="color: #ffffff;"></i></button>
        </div>
    </form>
    </div>
@endsection
