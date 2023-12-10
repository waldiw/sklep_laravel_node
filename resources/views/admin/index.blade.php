@extends('layouts.app')

@section('title', 'E-sklep Artykuły')

@section('content')
    <h2>Super admin:</h2>
    <div class="containerWrap">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Login</th>
                <th scope="col" colspan="2" class="alignC">Akcja</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th class="colorW" scope="row">{{ $loop->iteration }}</th>
                    <td >{{ $user->email }}</td>

                    <td class="alignC"><a
                            href="#"

                        >Zmień hasło</a></td>

                    <td class="alignC"><a
                            {{--                        <a href="javascript:void(0)">--}}
                            {{--                        sztuczka polegająca na tym, że <a>tag nie działa--}}
                            {{--                        przekierowanie na adres obsługiwane jest w skrypcie poniżej--}}
                            href="javascript:void(0)"
                            id="show-user"
                            data-url="#"
                        >Usuń</a></td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
