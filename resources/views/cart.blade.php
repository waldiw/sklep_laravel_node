<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sklep</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('css/iao-alert.min.css') }}" rel="stylesheet" type="text/css" >


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">


    {{--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>  --}}

    <script src="https://kit.fontawesome.com/9449ff78fb.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script src="{{ asset('js/iao-alert.jquery.min.js') }}"></script>

    

</head>

<body>
<div class="containerW shadow">
    <!-- <div class="image"> -->
    <img src="img/baner1.jpg" alt="Nature" class="responsive">
    <!-- </div> -->
    @include('Components.navbar')

    <div class="containerWrap">

        <div class="shoppingCart">
            <div class="">

                    <div class="clearCart">
                        <button class="btnContinueShopping" onclick="window.location.href='{{ route('shop') }}';">Kontynuj zakupy <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i></button>
                        <button  id="confirm" class="btnDeleteCart">Wyczyść koszyk &nbsp;<i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
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
{{--                                <div class="cartProductQuantity">--}}
                                    <td>

                                        <input type="number" class="articleQuantity" value="{{ $data['quantity'] }}"
                                               min="1" max="100"/>
                                        <input type="hidden" class="productId" value="{{ $data['articleId'] }}">

                                    </td>
                                    <td id="{{ $data['articleId'] }}" class="subtotal alignRight">{{ numberFormat($data['subtotal']) }} zł</td>
{{--                                </div>--}}
                                <td>
                                    <button class="btnDelete deleteCartData" >Usuń &nbsp;<i class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
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
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="alignRight">Wysyłka:</td>
                            <td class="shipping alignRight"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="alignRight">Do zapłaty:</td>
                            <td class="toPay alignRight"></td>
                            <td></td>
                        </tr>
                        @endif
                        </tfoot>
                    </table>
                @if (Cookie::get('shopping_cart') !== null)
                <div id="order" class="order">
                    <button class="btnContinueShopping" onclick="window.location.href='{{ route('order') }}';">Zamów &nbsp;<i class="fa-solid fa-check" style="color: #ffffff;"></i></button>
                </div>
                @endif
            </div>
        </div><!-- /.shopping-cart -->

    </div>

</div>


@include('Components.footer')
<br>

@include('Components.confirm')

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        cartload();

        $('.articleQuantity').change(function (e) {
            e.preventDefault();

            var productId = $(this).closest('tr').find('.productId').val();
            var quantity = $(this).closest('tr').find('.articleQuantity').val();

            $.ajax({
                url: '/update-cart',
                method: "POST",
                data: {
                    'quantity': quantity,
                    'product_id': productId,
                },
                success: function (response) {
                    var value = jQuery.parseJSON(response); //Single Data Viewing
                    $('#' + value['id']).html(numberFormat(value['subtotal']) + ' zł');
                    cartload();
                },
            });
         });

        $(document).on('click', '.deleteCartData' ,function(e) {
            e.preventDefault();

            var productId = $(this).closest('tr').find('.productId').val();

            $.ajax({
                url: '/delete-cart',
                method: "post",
                data: {
                    'product_id': productId,
                },
                success: function () {
                    $('#tr' + productId).remove();
                    cartload();
                }
            });

        });

        var modal = document.getElementById("confirmModal");
        var span = document.getElementsByClassName("close")[0];
        var btnNo = document.getElementsByClassName("btnNo")[0];

        $(document).on('click', '.btnDeleteCart' ,function(e) {
            e.preventDefault();

            modal.style.display = "block";
        });

        $(document).on('click', '.btnYes' ,function(e) {
            e.preventDefault();

            $.ajax({
                url: '/clear-cart',
                method: "post",
                data: {

                },
                success: function () {
                    $('#tableBody').remove();
                    $('#order').remove();
                    cartload();
                    modal.style.display = "none";
                }
            });
        });

        // When the user clicks anywhere outside of the modal or span, close it
        window.onclick = function (event) {
            if (event.target === modal || event.target === span || event.target === btnNo) {
                modal.style.display = "none";
            }
        }

        function cartload() {
            $.ajax({
                url: '/load-cart-data',
                method: "GET"
            }).done(function (response) {
                var value = jQuery.parseJSON(response); //Single Data Viewing
                var tfoot = document.getElementsByTagName("tfoot");
                // $('.basket-item-count').append($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
                // $('.basket-item-count').html($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
                $('.basketItemCount').html(numberFormat(value['totalCart']) + ' zł');
                $('.basketTotal').html(numberFormat(value['totalCart']) + ' zł');
                $('.shipping').html(numberFormat(value['shipping']) + ' zł');
                $('.toPay').html(numberFormat(value['toPay']) + ' zł');
                if (value['totalCart'] === 0)
                {
                    $(tfoot).remove();
                    $('#order').remove();
                }
            });
        }

        function numberFormat($number)
        {
            return ($number / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2})
        }

    });
</script>

</body>

</html>
