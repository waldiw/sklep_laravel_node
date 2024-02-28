@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Zamówienia:</h2>

    <table id="orderList">
        <thead id="orderListHead">
        <tr>
            <td>Numer</td>
            <td>Nazwa</td>
            <td>Adres</td>
            <td>Telefon</td>
            <td>Status</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td class="orderListId">{{ $order->id }}</td>
                <td class="orderListName">{{ $order->name }}</td>
                <td class="orderListAdress">{{ $order->adress }}</td>
                <td class="orderListPhone">{{ $order->phone }}</td>
                <td class="orderListStatus">{{ $order->status }}</td>
                <td>
                    <button class="btnUser info"
                            onclick="window.location.href='{{ route('editOrder', $order->id ) }}';">Szczegóły
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
