@extends('layouts.master')

@section('title', 'Mis Propuetas')

@section('styles')
    <style>
        table { 
            border: 2px solid #d88920;
            border-collapse: separate;
            border-left: 0 ;
            border-radius: 7px;
            border-spacing: 0px;
            
        }
        
        th{
            background-color: #02163a;
            color: white;
            border-bottom: 2px solid #d88920;
            text-align: center;
            
        }
        th, td {
            padding: 5px 4px 6px 4px; 
            text-align: left;
            vertical-align: top;
            
            border-left: 2px solid #d88920;    
            text-align: center;
        }

        td{
        
        }

        .enviado{
            color: #d88920
        }
        
    </style>    
@endsection

@section('content')







<div class="row">
    <div class="col-12">
    </div>
</div>
<br>
<div class="row">
    <div style="background-color: white; "
        class="ml-md-5 col-xs-12  col-md-9 rounded-lg mb-5">
        <br>

        <center><h4>Mis Propuestas</h4></center>
        
        <table with="100%" style="" class="w-100 table-responsive" id="tabla-propuestas">
            <thead class="">
                <tr>
                    <th>N° Propuesta</th>
                    <th>Participante</th>
                    <th>Monto</th>
                    <th>Rendimiento Pormedio (%)</th>
                    <th>Plazo Promedio (Días)</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>-</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($enc as $enc)
                    <tr>
                        <td>{{$enc->id_cotizacion}}</td>
                        <td>{{$enc->nombre_cotizacion}}</td>
                        <td>${{number_format($enc->monto_cot, 2, '.', ',' )}}</td>
                        <td>{{number_format($enc->tasa_ponderada, 2, '.', ',')}}</td>
                        <td>{{number_format($enc->dias_ponderados, 2, '.', ',' )}}</td>
                        <td>{{$enc->fecha_cot->format('Y-m-d H:i A')}}</td>
                        @if ($enc->estado_cot=="A")
                            <td>Borrador</td>  
                        @endif
                        @if ($enc->estado_cot=="B")
                            <td><strong class="enviado">Enviado</strong></td>  
                        @endif
                        <td><a href="{{route('cotizacion.index', $enc->id_cotizacion)}}">ver</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>

    <div style="height:70%" class="col-md-2 col-xs-12 rounded-lg ml-2 bg-white d-flex flex-column align-items-center">
        <div>
            <div class="menu-1 mt-5 ">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="submit" class="btn btn-round mb-3 btn-azul"  value="Cerrar sesión">
                </form>
                
                <a href="{{route('catalogo-creditos.index')}}" class="btn mb-5 btn-round btn-azul mt-2" name="btnPropuesta">Nueva Propuesta</a>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
   
    <script>
        $(document).ready(function() {


        $('#tabla-propuestas').DataTable({
            language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Propuestas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Propuestas",
                    "infoFiltered": "(Filtrado de _MAX_ Total de Propuestas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Propuestas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            'pageLength' : 15,
            'lengthMenu' : [15, 25, 40],
            "order": [[ 0, "desc" ]],
        });
      

        });
    </script>
   
@endsection
