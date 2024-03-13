@extends('layouts.shop')

@section('title', 'E-sklep Koszyk')

@section('content')

    <div class="containerWrap">
        <div class="shoppingCart">
            <div class="">
                <div class="clearCart">
                    <button class="btnContinueShopping" onclick="location.href='{{ route('shop') }}';">Kontynuj zakupy
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></button>
                    <button id="confirm" class="btnDeleteCart">Wyczyść koszyk &nbsp;<i class="fa-regular fa-trash-can"
                                                                                       style="color: #ffffff;"></i>
                    </button>
                </div>
                <table id="cartTable" class="cartTable">
                    <thead>
                    <tr class="tableHead">
                        <th>Nazwa produktu</th>
                        <th>Cena</th>
                        <th>Ilość</th>
                        <th>Wartość</th>
                        <th>Usuń</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    @foreach ($cart_data as $data)
                        <tr id="tr{{ $data['articleId'] }}" class="tableRow">
                            <td>{{ $data['articleName'] }}</td>
                            <td>{{ numberFormat($data['articlePrice']) }} zł</td>
                            <td>
                                <input type="number" class="articleQuantity" value="{{ $data['quantity'] }}"
                                       min="1" max="100"/>
                                <input type="hidden" class="productId" value="{{ $data['articleId'] }}">
                            </td>
                            <td id="{{ $data['articleId'] }}"
                                class="subtotal alignRight">{{ numberFormat($data['subtotal']) }} zł
                            </td>
                            <td>
                                <button class="btnDelete deleteCartData">Usuń &nbsp;<i class="fa-regular fa-trash-can"
                                                                                       style="color: #ffffff;"></i>
                                </button>
                                <input type="hidden" class="productId" value="{{ $data['articleId'] }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    @if (Cookie::get('shopping_cart'))
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="alignRight">Razem:</td>
                            <td class="basketTotal alignRight"></td>
                            <td></td>
                        </tr>
                    @endif
                    </tfoot>
                </table>
                @if (Cookie::get('shopping_cart') !== null)
                    <div id="order" class="order">
                        <button class="btnContinueShopping" onclick="window.location.href='{{ route('order') }}';">Zamów
                            &nbsp;<i class="fa-solid fa-check" style="color: #ffffff;"></i></button>
                    </div>
                @endif
            </div>
        </div><!-- /.shopping-cart -->
        <br>
    </div>

@endsection

@section('modal')
    @include('Components.confirm')
@endsection

@section('script')
    @include('scripts.cartShow')
@endsection
