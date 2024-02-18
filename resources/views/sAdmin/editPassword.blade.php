@extends('layouts.app')

@section('title', 'E-sklep Administracja')

@section('content')
    <h2>Zmiana hasła użytkownika: {{ $user->email }}</h2>
    <form method="post" action="{{ route('editPassword', $user->id ) }}" enctype="multipart/form-data">
        @csrf

        {{ method_field('PUT') }}

        <div class="row mb-3">
            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert"> <strong>{{ $message }}</strong> </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

            <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>
        </div>

        <div class="containerWrap">
                <div class="btnAddArticle">
                    <button type="submit" class="btnDodaj">Zmień hasło <i class="fa-solid fa-repeat" style="color: #ffffff;"></i></button>
                </div>
            </div>

    </form>
@endsection


