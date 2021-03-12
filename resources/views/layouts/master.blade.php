<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('csrf-token')
    <title>@yield('title')</title>
    <!--Styles-->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!--Select2 CSS-->
    <link href="{{asset('assets/select2/dist/css/select2.min.css')}}" rel="stylesheet" />
    <!--Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!--favicon-->
    <!--Estilos-->
    @yield('styles')
</head>

<body class="foliva">

    <!--header-->
    @include('layouts.nav')
    <!--nav-->

    <div class="container-fluid">
        @yield('content')
    </div>

    <!--footer-->
    <!--script-->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.23/r-2.2.7/datatables.min.js"></script>
    <script src="{{asset('assets/select2/dist/js/select2.min.js')}}"></script>
    @yield('scripts')
</body>

</html>
