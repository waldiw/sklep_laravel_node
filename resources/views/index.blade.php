<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-sklep</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--        <link rel="stylesheet" href="css\main.css">--}}
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/iao-alert.min.css') }}" rel="stylesheet" type="text/css">

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

    <img src="img/baner1.jpg" alt="Nature" class="responsive">

    @include('Components.navbar')

    <div class="opis">
        <h1>Cukierki Krówka</h1>
        Kremowe cukierki Krówka produkowane według tradycyjnej receptury bez użycia maszyn przemysłowych, formowane
        i zawijane ręcznie. Chcąc zachować ciągnący charakter cukierka należ przechowywać go w lodówce. Cukierki
        przechowywane w temperaturze pokojowej po pewnym czsie stają się kruche. Oprócz zawijania w tradycyjne
        papierki oferujemy usługę konfekcjonowania cukierków w papierki reklamowe zamawiającego. Stanowią one wtedy
        doskonały element reklamowy firmy lub uroczystości okolicznościowej. Aby dowiedzieć się więcej skontaktuj
        się z nami.
        <br>Skład: cukier, syrop glukozowy, śmietanka 16%, mleko w proszku.
    </div>
    <div class="containerWrap">
        @if($articles->count() > 0)
            <div class="containerWrap">
                @foreach($articles as $article)
                    @if($article->category === \App\Enums\Category::CUKIERKI)
                    <div class="wrapW articleDetails">
                        <div id="{{ $article->id }}" data-article="{{ route('showArticle', $article->id) }}"
                             class="showArticle">
                            <input type="hidden" class="productId" value="{{ $article->id }}">
                            <div class="content">
                                <div class="upper">
                                    <div class="nazwaTowaru">{{ $article->name }}</div>
                                    <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                                </div>
                                <div class="bottom">
                                    <div class="cena">Cena: {{ numberFormat($article->price) }} zł</div>
                                </div>
                            </div>
                        </div>
                        <button class="btnAddCart" onclick="">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"
                                                                                  style="color: #ffffff;"></i></button>
                    </div>
                    @endif
                @endforeach
            </div>
        @else
            <h3>Brak artykułów</h3>
        @endif
        <div class="wrapW">
            <div class="nazwaTowaru">Cukierki Krówka reklamowe</div>
            <div class="foto"><img src="img/cukierki_reklamowe.jpg" alt="Cukierki" class="responsive"></div>
            <div class="opisTowaru">Cukierki Krówka zawijane w papierki z logo zamawiającego.<br>Zachęcamy do kontaktu.
            </div>
            <button class="btnContact" onclick="location.href = '{{ route('showContact') }}'">Kntakt z nami</button>
        </div>
    </div>

    <div class="opis">
        <h1>Inne artykuły</h1>
    </div>
    <div class="containerWrap">
        @if($articles->count() > 0)
            <div class="containerWrap">
                @foreach($articles as $article)
                    @if($article->category === \App\Enums\Category::INNE)
                        <div class="wrapW articleDetails">
                            <div id="{{ $article->id }}" data-article="{{ route('showArticle', $article->id) }}"
                                 class="showArticle">
                                <input type="hidden" class="productId" value="{{ $article->id }}">
                                <div class="content">
                                    <div class="upper">
                                        <div class="nazwaTowaru">{{ $article->name }}</div>
                                        <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                                    </div>
                                    <div class="bottom">
                                        <div class="cena">Cena: {{ numberFormat($article->price) }} zł</div>
                                    </div>
                                </div>
                            </div>
                            <button class="btnAddCart" onclick="">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <h3>Brak artykułów</h3>
        @endif
    </div>
</div>



<footer>
    @include('Components.footer')
</footer>
<br>

<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modalContent articleDetails">
        <div class="modalHeader">
            <div id="modalPhoto" class="modalPhoto"></div>
            <div id="articleName"></div>
            <span class="close">&times;</span>
        </div>
        <div class="modalBody">
            <input id="articleId" type="hidden" class="productId" value="5">
            <p id="articleDescription"></p>
            <div id="articlePrice" class="cena"></div>
        </div>
        <div class="modalFooter">
            <button class="btnAddCart">Dodaj do koszyka <i class="fa-solid fa-cart-shopping"
                                                           style="color: #ffffff;"></i></button>
        </div>
    </div>
</div>

<script src="{{ asset('js/cookies.js') }}"></script>

<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("articleBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        var art = document.getElementById('articleDescription');
        var photo = document.getElementById('modalPhoto');
        var artN = document.getElementById('articleName');
        var artP = document.getElementById('articlePrice');

        cartload();

        $('.showArticle').click(function (e) {
            e.preventDefault();

            userURL = this.getAttribute('data-article');
            $.ajax({
                url: userURL,
                method: "GET"
            }).done(function (response) {
                artN.innerHTML = response.name;
                art.innerHTML = response.description;
                var price = (response.price / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2});
                artP.innerHTML = "Cena: " + price + " zł";
                $("#articleId").val(response.id);
                photo.innerHTML = "<img src=\"" + response.image + "\" class=\"modalImg\">";
                modal.style.display = "block";
            });
        });

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            modal.style.display = "none";

        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";

            }
        }

        // click button add to cart
        $('.btnAddCart').click(function (e) {
            e.preventDefault();

            var productId = $(this).closest('.articleDetails').find('.productId').val();
            var quantity = 1;
            $.ajax({
                url: "/add-to-cart",
                method: "POST",
                data: {
                    'quantity': quantity,
                    'product_id': productId,
                }
            }).done(function (response) {
                cartload();
                $.iaoAlert({
                    msg: "Produkt został dodany do koszyka.",
                    mode: "dark",
                    position: 'top-left'
                })
            });
        });

        function cartload() {

            $.ajax({
                url: '/load-cart-data',
                method: "GET"
            }).done(function (response) {
                var value = jQuery.parseJSON(response); //Single Data Viewing
                $('.basketItemCount').html((value['totalCart'] / 100).toLocaleString('pl-PL', {minimumFractionDigits: 2}) + " zł");

            });
        }
    });
</script>

</body>

</html>
