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
           <div>
                <label for="email" class="articleFormLabel">Adres e-mail do wysyłania potwierdzenia:</label>
                <input id="email" type="text" class=" @error('email') is-invalid error @enderror" name="email" value="{{ $param->email }}" >
            </div>
            <div class="btnAddArticle">
                <button type="submit" class="btnDodaj">Zapisz ustawienia <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
            </div>
        </form>
        <h4>Metody płatności:</h4>
        @if($shippings->count() > 0)
            <table id="shippingTable">
                <thead>
                    <tr>
                        <td>Nazwa</td>
                        <td>Cena</td>
                        <td>Typ</td>
                        <td>Aktywny</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($shippings as $shipping)
                    <tr>
                        <td id="shippingName">{{ $shipping->name }}</td>
                        <td>{{ number_format($shipping->shipping / 100, 2, ',', ' ') }} zł</td>
                        <td>{{ $shipping->type }}</td>
                        <td>{{ $shipping->active === 1 ? 'tak' : 'nie' }}</td>
                        <td>
                            <button class="btnDodaj buttonA"
                                    onclick="window.location.href='{{ route('editShipping', $shipping->id) }}';">Edytuj
                                <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                        </td>
                        <td>
                            <form method="post" action="{{ Route('deleteShipping', $shipping->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btnDelete buttonA" onclick="return confirm('Usunąć płatność?')">Usuń <i
                                        class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <div id="addShipping">
            <button class="btnDodaj" onclick="window.location.href='{{ route('createShipping') }}';">Dodaj metodę
                płatności <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
        </div>
    </div>

@endsection
