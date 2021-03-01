@extends('layouts.master')

@section('title', 'Administrador')


@section('content')
    <div class="row text-white">
        Bienvenido al área de Administrador
    </div>

    <div class="row">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="submit" class="btn btn-round btn-azul" value="Cerrar sesión">
        </form>
    </div>
@endsection
