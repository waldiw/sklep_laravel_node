@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Szczegóły zamówienia numer {{ $order->id }}:</h2>
    <p>Zamówienie z dnia: {{ $order->created_at }}</p>
    <p>Zamawiajacy: {{ $order->name }}</p>
    <p>Adres: {{ $order->adress }}</p>
    <p>E-mail: {{ $order->email }}</p>
    <p>Telefon: {{ $order->phone }}</p>

    @if($order->vat == 1)
        <p><b>Dane do faktury VAT:</b></p>
        <p>NIP: {{ $order->vatNumber }}</p>
        <p>Nazwa: {{ $order->vatName }}</p>
        <p>Adres: {{ $order->vatAdress }}</p>
    @endif

    <table id="orderTable" class="orderTable">
        <thead>
        <tr class="tableHead">
            <th>Nazwa produktu</th>
            <th>Cena</th>
            <th>Ilość</th>
            <th>Wartość</th>
        </tr>
        </thead>
        <tbody id="tableBody">
        @foreach ($order->carts as $data)
            <tr class="tableRow">
                <td>{{ $data['name'] }}</td>
                <td>{{ numberFormat($data['price']) }} zł</td>
                <td>{{ $data['quantity'] }}</td>
                <td class="subtotal alignRight">{{ numberFormat($data['price'] * $data['quantity']) }} zł</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td class="alignRight">Razem:</td>
            <td class="basketTotal alignRight">{{ numberFormat($totlOrder) }} zł</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="alignRight">{{ $order->shipping->name }}:</td>
            <td class="shipping alignRight">{{ numberFormat($order->shipping->shipping) }} zł</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="alignRight">Do zapłaty:</td>
            <td class="toPay alignRight">{{ numberFormat($order->shipping->shipping + $totlOrder) }} zł</td>
        </tr>
        </tfoot>
    </table>

    <div>
        <form method="post" action="{{ Route('editOrder', $order->id) }}">
            @csrf

            {{ method_field('PUT') }}

            <label for="status" class="articleFormLabel">Status:</label>
            <select id="status" name="status">
                <option value="" disabled>Wybierz status</option>
                <option value="nowe"{{ $order->status === 'nowe' ? ' selected' : '' }}>nowe</option>
                <option value="w realizacji"{{ $order->status === 'w realizacji' ? ' selected' : '' }}>w realizacji
                </option>
                <option value="zrealizowane"{{ $order->status === 'zrealizowane' ? ' selected' : '' }}>zrealizowane
                </option>
            </select>
            <button type="submit" class="btnDodaj">Zmień status <i class="fa-solid fa-repeat"
                                                                   style="color: #ffffff;"></i></button>
        </form>
    </div>
    <div class="orderDelete">
        <form method="post" action="{{ Route('deleteOrder', $order->id) }}">
            @csrf
            {{ method_field('DELETE') }}
            <button class="btnDelete orderDeleteBtn" onclick="return confirm('Usunąć zamówienie?')">Usuń zamówienie <i
                    class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
        </form>
    </div>
    <br>
@endsection
