@extends('layouts.master')

@section('title', 'Inicio de Sesión')


@section('content')
    <div class="container-login">
        <div class="d-flex w-100 justify-content-center">
            <form method="POST" action="{{ route('login') }}" class="p-4 frm-login" id="frm-login">
                @csrf
                <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                    <div class="linea"></div>
                    <div><span class="encabezado-login">Iniciar</span></div>
                    <div class="linea"></div>
                </div>
                <div class="form-group">
                    <label for="usuario">Nombre de usuario</label>
                    <input type="text" name="usuario" id="usuario" class="form-control" value="{{ old('usuario') }}"
                        autofocus>
                    <div class="texto-error div-error" id="error-usuario">
                        @error('usuario')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="position-r">
                        <input type="password" id="password" name="password" class="form-control">
                        <i class="fas fa-eye-slash icono-password" id="icono-password"></i>
                    </div>
                    <div class="texto-error div-error" id="error-password">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="row justify-content-center">
                    <input type="submit" value="Acceder" class="btn btn-radius btn-azul">
                </div>
            </form>
        </div>
        <div class="row justify-content-center p-4">
            <span>&copy <span id="cr-year"></span> AS Analytics. Todos los derechos reservados.</span>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/main.js') }}"></script>
@endsection
