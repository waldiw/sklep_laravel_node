@extends('layouts.app')

@section('title', 'E-sklep Artykuły')

@section('content')
    <h2>Super admin:</h2>
    <div class="containerWrap">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col" colspan="2" class="alignC">Akcja</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th class="colorW" scope="row">{{ $loop->iteration }}</th>
                    <td >{{ $user->email }}</td>

                    <td class="alignC"><a href="{{ route('editPassword', $user->id ) }}">Zmień hasło</a></td>
                    @if($user->role != \App\Enums\UserRole::ADMINISTRATOR)
                        <td class="alignC"><a href="{{ route('deleteUser', $user->id) }}" id="show-user" data-url="#">Usuń</a></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <button class="btnDodaj" onclick="window.location.href='{{ route('createUser') }}';">Dodaj użytkownika <i class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
    </div>


    <h4>Metody płatności:</h4>
    <div class="containerWrap">
    @if($shippings->count() > 0)

        <table id="shippingTable">
            <thead>
            <tr>
                <td>Nazwa</td>
                <td>Cena</td>
                <td>Typ</td>
                <td>Usunięta</td>
            </tr>
            </thead>
            <tbody>
            @foreach($shippings as $shipping)
                <tr>
                    <td id="shippingName">{{ $shipping->name }}</td>
                    <td>{{ number_format($shipping->shipping / 100, 2, ',', ' ') }} zł</td>
                    <td>{{ $shipping->type }}</td>
                    <td class="{{ $shipping->delete === 1 ? 'enabled' : '' }}">{{ $shipping->delete === 1 ? 'tak' : 'nie' }}</td>
                     {{--  <td><button class="btnDodaj buttonA" onclick="window.location.href='{{ route('editArticle', $article->id) }}';">Edytuj <i class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button></td>  --}}
                    <td>

                    </td>
                </tr>

            @endforeach
            </tbody>
        </table>

        <form method="post" action="">
            @csrf
            {{ method_field('DELETE') }}
            <br>
            <button class="btnDelete " onclick="return confirm('Wykasować usunięte płatności?')">Kasuj usunięte metody <i
                    class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
        </form>

    @endif
    </div>


    <h4>Zamówienia:</h4>
    <div class="containerWrap">
    <table id="orderList">
        <thead id="orderListHead">
        <tr>
            <td>Numer</td>
            <td>Nazwa</td>
            <td>Adres</td>
            <td>Status</td>
            <td>Usunięte</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td class="orderListId">{{ $order->id }}</td>
                <td class="orderListName">{{ $order->name }}</td>
                <td class="orderListAdress">{{ $order->adress }}</td>

                <td class="orderListStatus">{{ $order->status }}</td>
                <td class="{{ $order->delete === 1 ? 'enabled' : '' }}">{{ $order->delete === 1 ? 'tak' : 'nie' }}</td>
                <td class="orderListAction"><a href="{{ route('editOrder', $order->id) }}">szczegóły</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form method="post" action="">
        @csrf
        {{ method_field('DELETE') }}
        <br>
        <button class="btnDelete " onclick="return confirm('Wykasować usunięte zamówienia?')">Kasuj usunięte zamówienia <i
                class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
    </form>
    </div>
@endsection
