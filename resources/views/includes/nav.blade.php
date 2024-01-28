<nav class="main-menu">
    <ul>
        <li>
            <a href="#">Zamówienia</a>
        </li>
        <li>
            <a href="{{ route('articles') }}">Artykuły</a>
        </li>
        <li>
            <a href="{{ route('admin') }}">Administracja</a>
        </li>
        <li>
            <a class="koszyk" href="#" onclick="document.getElementById('logout-form').submit();" >{{ __('Logout') }}</a>
        </li>
    </ul>
</nav>
