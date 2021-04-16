@extends('layouts.master')

@section('title', 'Propuesta')

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
    </style>
    
@endsection

@section('menu')
    @include('layouts.nav')
@endsection

@section('content')
<script>
    function eliminar(variable){
        swal.fire({
        type: "question",
        title: "¿Desea eliminar registro?",
        text: "No se prodrá recuperar el registro",
        showCancelButton: true,
        cancelButtonColor: "red",
        ShowConfirmButton: true,
        confirmButtonColor: '#5cb85c',
        confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.value) {
                $('#question').append("<input type='hidden' name='id' value='"+variable+"'><input type='hidden' name='bandera' value='1'>");
                $('#frmCotizacion').submit();
            }
        });
        
    }

    function eliminarVarios(){
        swal.fire({
        type: "question",
        title: "¿Desea eliminar todos los registros seleccionados?",
        text: "No se prodrán recuperar los registros",
        showCancelButton: true,
        cancelButtonColor: "red",
        ShowConfirmButton: true,
        confirmButtonColor: '#5cb85c',
        confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.value) {
                $('#ape').append("<input type='hidden' name='bandera' value='2'>");
                $('#frmTable').submit();
            }
        });
        console.log(variable);
    }


    function editar(idEnc, idDet, monto, tasa, comentarios, industria, rendimiento, pais){
        $('#monto').val('');
        $('#rendimiento').val('');
        $('#comentarios').val('');
        $('#idEnc').val('');
        $('#idDet').val('');
        $('#pais').val('');

        $('#pais').val(pais);
        $('#monto').val(monto);
        $('#industria').val(industria);
        $('#rendimiento').val(rendimiento);
        $('#comentarios').val(comentarios);
        $('#idEnc').val(idEnc);
        $('#idDet').val(idDet);
        $('#modificar').modal();

        $("#monto").attr({
        "max" : monto,        
        "min" : 0          
        });
    }
    var bandera = 0;
    //document.getElementById("order").addEventListener("click", ordenar);
    function ordenar(){
        
        if (bandera == 0) {
            $('#tabla-cot').DataTable({
                destroy: true,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Carteras",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Carteras",
                    "infoFiltered": "(Filtrado de _MAX_ Total de Carteras)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Carteras",
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
                'pageLength' : 20,
                'lengthMenu' : [20, 30, 45],

            });
        bandera = 2;
        } else{
            $('#tabla-cot').DataTable({
                destroy: true,
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Carteras",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Carteras",
                    "infoFiltered": "(Filtrado de _MAX_ Total de Carteras)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Carteras",
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
                'pageLength' : 20,
                'lengthMenu' : [20, 30, 45],
                "ordering": false,
            }); 
            bandera = 0; 
        }
    } 
</script>


    @include('cotizacion.modals.cotizacionModal')
    

    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <br>
    <div class="row">
        <div style="background-color: white"
            class="ml-md-5 col-xs-12 table-responsive col-md-9 rounded-lg mb-5">
            
            <br>
            
            
            <form action="{{route('cotizazcion.destroy')}}" id="frmCotizacion" method="POST">
                @csrf
                @method('delete')
            
                <div id="question"></div>
            </form>
                <div class="row">
                    <div class="col-md-12">
                        <center><h3>{{$enc->nombre_cotizacion}}</h3></center>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label>Rendimiento Promedio Ponderado (%)</label>
                        <input type="text" readonly  class="numero" value="{{number_format($enc->tasa_ponderada, 2, '.',',') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Plazo Promedio Ponderado (Días)</label>
                        <input type="text" readonly  class="numero" value="{{number_format($enc->dias_ponderados, 2, '.', ',')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5"></div>
                </div>
                
            
                <span class="text-danger">
                    
                        @error('industria')
                            <div class="alert alert-danger" role="alert">
                               No se pudo modificar porque {{ $message }}
                            </div>
                        @enderror
                        @error('monto')
                            <div class="alert alert-danger" role="alert">
                                No se pudo modificar porque {{ $message }}
                            </div>
                        @enderror
                        @error('comentarios')
                            <div class="alert alert-danger" role="alert">
                                No se pudo modificar porque {{ $message }}
                            </div>
                        @enderror
                        @error('tasa')
                            <div class="alert alert-danger" role="alert">
                                No se pudo modificar porque {{ $message }}
                            </div>
                        @enderror
                      
                </span>
            <input type="button" class="btn btn-danger mb-2"  value="Eliminar seleccionados" onclick="eliminarVarios()">
            <input type="button" class="btn btn-warning mb-2"  value="Habilitar filtros" onclick="ordenar()">
            
            
            <form action="{{route('cotizazcion.destroy')}}" id="frmTable" method="POST">
                @csrf
                @method('delete')
                <div id="ape"></div>
                <table style="text-align:center;" class="table-responsive " with="100%" class="w-100" id="tabla-cot">
                    <thead class="">
                        <tr>
                            <th class="h">ID</th>
                            <th class="h">Deudor</th>
                            <th class="h">Monto</th>
                            <th class="h">Rendimiento (%)</th>
                            <th class="h">Fecha Vencimiento</th>
                            <th class="h">Grupo</th>
                            <th class="h">País</th>
                            <th class="h">Industria</th>
                            <th style="color: white">selec</th>
                            @if ($enc->estado_cot=="A")
                                <th style="color: white">-</th>
                                <th style="color: white">-</th>
                            @endif
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($det as $detalles)
                        
                            <tr class="tbh">
                                <td class="bl">{{$detalles->id_cotizacion}}</td>
                                <td class="bl">{{ $detalles->nombre_deudor }}</td>
                                <td class="bl">${{ number_format($detalles->monto_cot, 2, '.', ',' ) }}</td>
                                <td class="bl">{{ number_format(($detalles->rendimiento), 2, '.', ',' ) }}%</td>
                                <td class="bl">{{ substr($detalles->fecha_cot, 0, -8) }}</td>
                                <td class="bl">{{ $detalles->grupo_economico }}</td>
                                <td class="bl" >{{$detalles->pais}}</td>
                                <td class="blr" >{{$detalles->industria}}</td>
                                <td>
                                    <center>
                                        <input type="checkbox" name="eliminar[]" value="{{$detalles->id_cotizacion}}">
                                    </center>
                                </td>
                                @if ($enc->estado_cot=="A")
                                    <td  style="border-block-color: white">
                                        <input type="image" form="formulario1" class="btn-calc math sombra" height="40px" width="40px" 
                                        src="{{asset('assets/img/up.png')}}" onclick="editar({{$detalles->id_credito}},{{$detalles->id_cotizacion}},{{$detalles->monto_cot}}, {{$detalles->tasa_cot}}, '{{$detalles->comentarios}}', '{{$detalles->industria}}', {{$detalles->rendimiento}}, '{{$detalles->pais}}')"  />
                                    </td>
                                    <td>
                                        <input type="image" form="formulario1" class="btn-calc math sombra" height="40px" width="40px" 
                                        src="{{asset('assets/img/del.png')}}" onclick="eliminar({{$detalles->id_cotizacion}});"  />
                                    </td>
                                @endif
                            </tr>
                        
                        @endforeach
                        
                    </tbody>
                    <tr class="bb">
                        <th class="h">-</th>
                        <th class="h">-</th>
                        <th class="h">${{number_format($sumMonto->monto, 2, '.', ',' )}}</th>
                        <th class="h">{{number_format($enc->tasa_ponderada, 2, '.', ',')}}</th>
                        <th class="h">-</th>
                        <th class="h">-</th>
                        <th class="h">-</th>
                        <th class="h">-</th>
                        
                        
                    </tr>
                </table>
            </form>


            
            <br>
        <br>
        </div>
        
        <div style="height: 80%" class="col-md-2 col-xs-12 rounded-lg ml-2  bg-white d-flex flex-column align-items-center">
            <div>
                <div class="menu-1 mt-5 ">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit"  class="btn btn-round btn-azul" value="Cerrar sesión">
                    </form>
                    <a href="{{route('cotizacion.mostrar', $enc)}}" class="btn mb-5 btn-round btn-naranja mt-2" name="btnPropuesta">Enviar</a>
                    <br>
                    <a href="{{route('propuestas.index')}}" class="btn mb-2 btn-round btn-griz  mt-2" name="btnPropuesta">Mis propuestas</a>
                    <br>
                    <a href="{{route('catalogo-creditos.index')}}" class="btn mb-5 btn-round btn-azul-oscuro " name="btnPropuesta">Nueva Propuesta</a>
                </div>
            </div>
            
        </div>
        
    </div>

    <div class="row justify-content-center p-4" style="color:#fff">
        <span>&copy <span id="cr-year"></span> AS Analytics. Todos los derechos reservados.</span>
    </div>

    {{-- @php
        $alerta = $_SESSION["alerta"]   
    @endphp --}}

@endsection

@section('scripts')
   
        {{-- @if ($alerta == "")
            <script type="text/javascript">
                var toast = new Toasty();
                
                toast.success("Propuesta generada con éxito");
            </script>  
        @endif --}}
    

    <script type="text/javascript">
        $(document).ready(function() {
            
         $('#tabla-cot').DataTable({
                    language: {
                        "decimal": "",
                        "emptyTable": "No hay información",
                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Carteras",
                        "infoEmpty": "Mostrando 0 a 0 de 0 Carteras",
                        "infoFiltered": "(Filtrado de _MAX_ Total de Carteras)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "Mostrar _MENU_ Carteras",
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
                    'pageLength' : 20,
                    'lengthMenu' : [20, 30, 45],
                    "ordering": false,
         });       
        });

    </script>

    
@endsection