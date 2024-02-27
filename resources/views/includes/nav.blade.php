<nav class="main-menu">
    <ul>
        <li>
            <a href="{{ route('home') }}">Zamówienia</a>
        </li>
        <li>
            <a href="{{ route('articles') }}">Artykuły</a>
        </li>
        <li>
            <a href="{{ route('admin') }}">Administracja</a>
        </li>
        <li>
            <a href="{{ route('statute') }}">Regulamin</a>
        </li>
        <li>
            <a href="{{ route('contact') }}">Kontakt</a>
        </li>
        <li>
            <a class="koszyk" href="#" onclick="document.getElementById('logout-form').submit();" >{{ __('Logout') }}</a>
        </li>
    </ul>
</nav>
