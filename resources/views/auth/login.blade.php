@extends('layouts.master')

@section('title', 'Inicio de Sesión')


@section('content')
    <div class="container-login">
        <div class="d-flex w-100 justify-content-center">
            <form action="" class="p-4 frm-login">
                <div class="form-group">
                    <label for="usuario">Nombre de usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" value="{{ old('usuario') }}"
                        autofocus required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="position-r">
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <input type="submit" value="Acceder" class="btn btn-success">
                </div>
            </form>
        </div>
    </div>
@endsection
