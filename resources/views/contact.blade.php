@extends('layouts.shop')

@section('title', 'E-sklep Kontakt')

@section('content')
<div class="opis">
<h2>Kontakt z nami:</h2>
    <div id="contact">
        {!! $contact !!}
    </div>
</div>
@endsection

@section('script')
    @include('scripts.cartSum')
@endsection

