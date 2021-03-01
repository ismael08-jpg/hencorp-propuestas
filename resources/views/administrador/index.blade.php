@extends('layouts.master')

@section('title', 'Administrador')


@section('content')
    <div class="row text-white p-5">
        Bienvenido al área de Administrador
    </div>

    <div class="row p-5">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-round btn-azul" value="Cerrar sesión">
        </form>
    </div>
@endsection
