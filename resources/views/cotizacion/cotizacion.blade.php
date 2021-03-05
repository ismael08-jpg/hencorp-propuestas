@extends('layouts.master')

@section('title', 'Catalogo de Créditos')


@section('content')
    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <br>
    <div class="row">
        <div style="background-color: white"
            class="ml-md-5 col-xs-12 table-responsive table-responsive col-md-9 rounded-lg mb-5">
            <br>
            
            <form action="" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <center><h3>{{$enc->nombre_deudor}}</h3></center>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Tasa Ponderada</label>
                        <input type="text"  class="numero" value="{{$enc->tasa_ponderada}}">
                    </div>
                    <div class="col-md-6">
                        <label>Días Ponderados</label>
                        <input type="text"  class="numero" value="{{$enc->dias_ponderados}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5"></div>
                </div>
                
            </form>

            
            <table with="100%" class="w-100 table-hover tabla" id="tabla-catalogo">
                <thead class="">
                    <tr>
                        <th scope="col">Monto</th>
                        <th scope="col">Tasa %</th>
                        <th scope="col">Fecha Vencimiento</th>
                        <th>Grupo/país</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                {{$acumTasa=0, $acumMonto=0}}
                <tbody>
                    @foreach ($det as $detalles)
                    
                        <tr>
                            <td scope="row">{{ $detalles->monto_cot }}</td>
                            <td>{{ $detalles->tasa_cot }}</td>
                            <td>{{ $detalles->fecha_cot }}</td>
                            <td>{{ $detalles->grupo_economico }}</td>
                            <td>{{ $detalles->grupo_economico }}</td>
                            <td>
                                <button class="btn btn-danger">DEL</button>
                                <button class="btn btn-success">UPD</button>
                            </td>
                        </tr>
                    {{$acumTasa+=$detalles->tasa_cot, $acumMonto+=$detalles->monto_cot }}
                    @endforeach
                    <tr>
                        <th>{{$acumMonto}}</th>
                        <th>{{$acumTasa}}</th>
                        <th>-</th>
                        <th>-</th>
                        <th>-</th>
                    </tr>
                </tbody>
            </table>
            <br>
        <br>
        </div>
        
        <div class="col-md-2 col-xs-12 bg-naranja d-flex flex-column align-items-center">
            <div class="menu-1 mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="submit" class="btn btn-round btn-azul" value="Cerrar sesión">
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tabla-catalogo').DataTable({
                'pageLength' : 15,
                'lengthMenu' : [15, 25, 40],
            });
        });
    </script>
@endsection
