@extends('layouts.master')

@section('title','Catalogo de Créditos')


@section('content')

    <div class="row">
        <div class="col-12">
            <br>
        </div>
    </div>
    <div class="row">
            <div style="background-color: white" class="ml-md-5 col-xs-12 table-responsive table-responsive  col-md-9  rounded-lg">
                <form action="{{route('catalogo-creditos.index')}}" method="GET">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <label for="">Monto disponible mayor a</label>
                            <input type="number" name="mayor_a" class="numero">
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <label for="">menor a</label>
                            <input type="number" name="menor_a" class="numero">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-2">
                            <center>
                                <button class="filtrar">filtrar</button>
                            </center>
                        </div>
                        <div class="col-md-5"></div>
                    </div>
                </form>
                <br>
                <table with="100%" class=" w-100 table-hover tabla">
                    <thead class="">
                            <tr>
                            <th scope="col">Deudor</th>
                            <th scope="col">Monto disponible hasta por</th>
                            <th scope="col">Tasa %</th>
                            <th scope="col">Vencimiento</th>
                            <th>Grupo/país</th>
                            </tr>
                    </thead>
                        
                    <tbody>
                            @foreach ($catalogo as $catalogos)
                            <tr>
                                <td scope="row">{{$catalogos->nombre_deudor}}</td>
                                <td>{{$catalogos->NLP}}</td>
                                <td>{{$catalogos->costo_ponderado}}</td>
                                <td>{{$catalogos->fecha_vencimiento}}</td>
                                <td>{{$catalogos->grupo_economico}}</td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
                <br>
                {{$catalogo->links()}}
                
                <br>
                <br>
            </div>
            <div class="col-md-2 col-xs-12 bg-naranja">
                <div class="menu-1">

                </div>
            </div>
    </div>    

    
@endsection