@extends('layouts.master')

@section('title', 'Mis Propuetas')

@section('styles')
    
    <style>
         .h{
            background-color: #02163a;
            color: white;
            border: #02163a 2px solid;
        }

        .bl{
            border-left: #02163a 2px solid;
        }
        .blr{
            border-left: #02163a 2px solid;
            border-right: #02163a 2px solid;;
        }

        .bb{
            border-bottom:  #02163a 2px solid;
        }

        .tbh:hover{
            background-color: rgb(226, 234, 248);
        }

        .btn-calc {
            margin: 4px;
            width: 45px;
            height: 45px;
            border: none;
            text-decoration: none;
            cursor: pointer;
            border-radius: 5px;
            text-transform: capitalize;
            font-size: .9em;
            background: transparent;
            color: #939393;
            outline: none !important;
        }

        .btn-calc.sombra:focus {
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.2);
        }

        .btn-calc::-moz-focus-inner {
            border: none;
        }

        .enviado{
            color: #d88920
        }
        
    </style>    
@endsection

@section('menu')
    @include('layouts.nav')
@endsection

@section('content')


<script>
    function copiar(idEnc, participante){
        $('#idEnc').val('');
        $('#idEnc').val(idEnc); 
        $('#participante').val('');
        $('#participante').val(participante); 
        $('#copiar').modal();

       
        
        $('#nump').append(idEnc)

        $("#monto").attr({
        "max" : monto,        
        "min" : 0          
        });
    }
</script>


<!-- Modal -->
<div class="modal fade" id="copiar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Copiar Propuesta  N°</h5><h5 class="modal-title" ><div id="nump"></div></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('propuestas.copiar')}}" method="POST">
            @csrf
            <div class="modal-body">  
                    <input type="hidden" name="idEnc" id="idEnc">
                
                    <div class="row">
                        <div class="col-12">
                            <label>Participante</label>
                            <input type="text" required  name="participante" class="form-control" id="participante">
                        </div>
                    </div>
            </div>
            <p class="ml-2">Posteriormente se podrá modificar los registros de la propuesta</p>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Si, Copiar</button>
            </div>
        </form>

      </div>
    </div>

  </div>

  {{-- end modal --}}


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
                    <th class="h">N° Propuesta</th>
                    <th class="h">Participante</th>
                    <th class="h">Monto</th>
                    <th class="h">Rendimiento Pormedio (%)</th>
                    <th class="h">Plazo Promedio (Días)</th>
                    <th class="h">Fecha</th>
                    <th class="h">Estado</th>
                    <th style="color: white">-</th>
                    <th style="color: white">-</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($enc as $enc)
                    <tr class="tbh">
                        <td class="bl">{{$enc->id_cotizacion}}</td>
                        <td class="bl">{{$enc->nombre_cotizacion}}</td>
                        <td class="bl">${{number_format($enc->monto_cot, 2, '.', ',' )}}</td>
                        <td class="bl">{{number_format($enc->tasa_ponderada, 2, '.', ',')}}</td>
                        <td class="bl">{{number_format($enc->dias_ponderados, 2, '.', ',' )}}</td>
                        <td class="bl">{{$enc->fecha_cot->format('Y-m-d H:i A')}}</td>
                        @if ($enc->estado_cot=="A")
                            <td class="bl">Borrador</td>  
                        @endif
                        @if ($enc->estado_cot=="B")
                            <td class="bl"><strong class="enviado">Enviado</strong></td>  
                        @endif
                        <td><a href="{{route('cotizacion.index', $enc->id_cotizacion)}}"><img src="{{asset('assets/img/ojo.png')}}" height="40px"  alt="40px"></a></td>
                        <td><button class="btn-calc math sombra" onclick="copiar({{$enc->id_cotizacion}}, '{{$enc->nombre_cotizacion}}')"><img src="{{asset('assets/img/copiar.png')}}" height="40px" width="40px" alt=""></button></td>
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
                
                <a href="{{route('catalogo-creditos.index')}}" class="btn mb-5 btn-round btn-azul-oscuro mt-2" name="btnPropuesta">Nueva Propuesta</a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-4" style="color:#fff">
    <span>&copy <span id="cr-year"></span> AS Analytics. Todos los derechos reservados.</span>
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
