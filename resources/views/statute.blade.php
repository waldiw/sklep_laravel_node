@extends('layouts.shop')

@section('title', 'E-sklep Regulamin')

@section('content')
    <div id="showStatute">
        {!! $statute !!}
    </div>
@endsection


@section('script')
    @include('scripts.cartSum')
@endsection

