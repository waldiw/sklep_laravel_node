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

    <script type="text/javascript">
        var perfEntries = performance.getEntriesByType("navigation");
        if (perfEntries[0].type === "back_forward") {
            location.reload(true);
        }
    </script>

</head>

<body>
@include('Components.message')
<div class="containerW shadow">
    <!-- <div class="image"> -->
    <img src="img/baner1.jpg" alt="Nature" class="responsive">
    <!-- </div> -->
    @include('Components.navbar')

    <div class="containerOrder">
        <h2>Zamówienie:</h2>
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
            @foreach ($cart as $data)
                <tr id="tr{{ $data['articleId'] }}" class="tableRow">
                    <td>{{ $data['articleName'] }}</td>
                    <td>{{ numberFormat($data['articlePrice']) }} zł</td>
                    <td>{{ $data['quantity'] }}</td>
                    <td id="{{ $data['articleId'] }}" class="subtotal alignRight">{{ numberFormat($data['subtotal']) }} zł</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                 <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Razem:</td>
                    <td class="basketTotal alignRight">{{ numberFormat($totalCart) }} zł</td>
                 </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Wysyłka:</td>
                    <td class="shipping alignRight">{{ numberFormat($shipping) }} zł</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td class="alignRight">Do zapłaty:</td>
                    <td class="toPay alignRight">{{ numberFormat($toPay) }} zł</td>
                </tr>
            </tfoot>
        </table>

        <div id="containerForm" class="containerForm">
            <form id="orderForm" class="orderForm" method="post" action="{{ route('order') }}">
                @csrf
                <div class="adressForm">
{{--                    <div class="form-field">--}}
                        <label for="name" >Imię i nazwisko zamawiającego:</label>
                        <input id="name" class="form-field @error('name') is-invalid error @enderror" value="{{ old('name') }}" type="text" name="name" placeholder="Imię i nazwisko">
{{--                    </div>--}}
                    Adres:<br>
                    <label for="street" >Ulica, numer domu, numer mieszkannia:</label>
                    <input id="street" class="form-field @error('street') is-invalid error @enderror" value="{{ old('street') }}" type="text" name="street" placeholder="Ulica">
                    <label for="city" >Miejscowość:</label>
                    <input id="city" class="form-field @error('city') is-invalid error @enderror" value="{{ old('city') }}" type="text" name="city" placeholder="Miejscowość">
                    <label for="post" >Poczta:</label>
                    <input id="post" class="form-field @error('post') is-invalid error @enderror" value="{{ old('post') }}" type="text" name="post" placeholder="00-000 poczta">
                    <label for="email" >E-mail:</label>
                    <input id="email" class="form-field @error('email') is-invalid error @enderror" value="{{ old('email') }}" type="text" name="email" placeholder="e-mail">
                    <label for="phone" >Numer telefonu:</label>
                    <input id="phone" class="form-field @error('phone') is-invalid error @enderror" value="{{ old('phone') }}" type="text" name="phone" placeholder="Telefon">
                    <label for="comments" >Uwagi do zamówienia:</label>
                    <textarea id="comments" class="form-field @error('comments') is-invalid error @enderror" name="comments" placeholder="Uwagi do zamówienia">{{ old('comments') }}</textarea>
                </div>
                <div class="vatForm">
                    <div class="checkVat">
                        <input type="checkbox" id="check" name="vat" value="1" {{ old('vat') ? 'checked' : '' }}/>
                        <label for="check"> Faktura VAT</label>
                    </div>
                    <div id="displayVat" class="displayVat">
                        <label for="vatNumber">Numer NIP:</label>
                        <input id="vatNumber" class="form-field @error('vatNumber') is-invalid error @enderror" value="{{ old('vatNumber') }}" type="text" name="vatNumber" placeholder="NIP">
                        <label for="vatName">Nazwa firmy:</label>
                        <input id="vatName" class="form-field @error('vatName') is-invalid error @enderror" value="{{ old('vatName') }}" type="text" name="vatName" placeholder="Nazwa firmy">
                        <label for="vatStreet">Ulica, numer domu, numer mieszkannia:</label>
                        <input id="vatStreet" class="form-field @error('vatStreet') is-invalid error @enderror" value="{{ old('vatStreet') }}" type="text" name="vatStreet" placeholder="Ulica">
                        <label for="vatCity">Miejscowość:</label>
                        <input id="vatCity" class="form-field @error('vatCity') is-invalid error @enderror" value="{{ old('vatCity') }}" type="text" name="vatCity" placeholder="Miejscowość">
                        <label for="vatPost">Poczta:</label>
                        <input id="vatPost" class="form-field @error('vatPost') is-invalid error @enderror" value="{{ old('vatPost') }}" type="text" name="vatPost" placeholder="00-000 poczta">
                    </div>
                </div>
            </form>
            <div id="order" class="order">
                <button type="submit" class="btnContinueShopping" form="orderForm">Potwierdź zamówienie &nbsp;<i class="fa-solid fa-check" style="color: #ffffff;"></i></button>
            </div>
        </div>

    </div><!-- /.oontainerOrder -->



</div>


@include('Components.footer')
<br>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if ($('#check').is(':checked'))
        {
            $('#displayVat').removeClass('displayVat');
        }
        else {
            $('#displayVat').addClass('displayVat');
        }

        cartload();

        $(document).on('click', '.checkVat' ,function(e) {
            // e.preventDefault();


            if ($('#check').is(':checked'))
            {
                $('#displayVat').removeClass('displayVat');
            }
            else{
                $('#displayVat').addClass('displayVat');
                $('#nip').val('');
                $('#vatName').val('');
                $('#vatStreet').val('');
                $('#vatCity').val('');
                $('#vatPost').val('');
            }

            });

         function cartload() {
            $.ajax({
                url: '/load-cart-data',
                method: "GET"
            }).done(function (response) {
                var value = jQuery.parseJSON(response); //Single Data Viewing
                var tfoot = document.getElementsByTagName("tfoot");
                // $('.basket-item-count').append($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
                // $('.basket-item-count').html($('<span class="badge badge-pill red">'+ value['totalcart'] +'</span>'));
                $('.basketItemCount').html((value['totalCart'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + ' zł');
                // $('.basketTotal').html((value['totalCart'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + ' zł');
                // $('.shipping').html((value['shipping'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + ' zł');
                // $('.toPay').html((value['toPay'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + ' zł');
                if (value['totalCart'] === 0)
                {
                    $('#orderTable').remove();
                    $('#containerForm').remove();
                }

            });
        }

    });
</script>

</body>

</html>
