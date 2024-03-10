{{--<div class="navbarW sticky">--}}
{{--    <div class="koszyk">--}}
{{--        <a href="{{ route('cart') }}">Koszyk</a>&nbsp;--}}
{{--        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>--}}
{{--        <span class="basketItemCount"></span>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="navbarW sticky">
    <nav class="nav-shop">
        <ul>
            <li>
                <a href="https://osmolecko.pl">O nas</a>
            </li>
            <li>
                <a href="{{ route('showStatute') }}">Regulamin</a>
            </li>
            <li>
                <a href="{{ route('showContact') }}">Kontakt</a>
            </li>
            <li>
                <a href="{{ route('shop') }}">Sklep</a>
            </li>
            <li style="float:right">
                    <div class="koszyk">
                        <a href="{{ route('cart') }}">Koszyk</a>&nbsp;
                        <i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i>
                        <span class="basketItemCount"></span>
                    </div>
            </li>
        </ul>
    </nav>

</div>
