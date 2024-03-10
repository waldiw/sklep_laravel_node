@extends('layouts.app')

@section('title', 'E-sklep Artykuły')

@section('content')
    <h2>Artykuły:</h2>
    @if($articles->count() > 0)
        <div class="containerWrap">
            @foreach($articles as $article)
                <div class="wrapW">
                    <div class="content">
                        <div class="upper">
                            <div class="nazwaTowaru">{{ $article->name }}</div>
                            <div class="foto"><img src="{{ $article->photo }}" alt="Cukierki" class="responsive"></div>
                        </div>
                        <div class="bottom">
                            <div class="cena">Cena: {{ number_format($article->price / 100, 2, ',', ' ') }} zł</div>
                            <div class="activeArticle"> aktywny: {{ $article->active === 1 ? 'tak' : 'nie' }}</div>
                        </div>
                    </div>
                    <div class="wrapFooter">
                        <div class="containerButton">
                            <button class="btnDodaj buttonA"
                                    onclick="window.location.href='{{ route('editArticle', $article->id) }}';">Edytuj <i
                                    class="fa-regular fa-pen-to-square" style="color: #ffffff;"></i></button>
                            <form method="post" action="{{ Route('deleteArticle', $article->id) }}">
                                @csrf
                                {{ method_field('DELETE') }}
                                <button class="btnDelete buttonA" onclick="return confirm('Usunąć artykuł?')">Usuń <i
                                        class="fa-regular fa-trash-can" style="color: #ffffff;"></i></button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <h3>Brak artykułów</h3>
    @endif
    <div class="addArticle">
        <button class="btnDodaj" onclick="window.location.href='{{ route('createArticle') }}';">Nowy artykuł <i
                class="fa-regular fa-square-plus" style="color: #ffffff;"></i></button>
    </div>

@endsection
