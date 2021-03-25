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
    </style>
    
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
                $('#question').append("<input type='hidden' name='btnDelete'> <input type='hidden' name='id' value='"+variable+"'>");
                $('#frmCotizacion').submit();
            }
        });
        console.log(variable);
    }


    function editar(idEnc, idDet, monto, tasa, comentarios, industria){
        $('#monto').val('');
        $('#tasa').val('');
        $('#comentarios').val('');
        $('#idEnc').val('');
        $('#idDet').val('');

        $('#monto').val(monto);
        $('#industria').val(industria);
        $('#tasa').val(tasa);
        $('#comentarios').val(comentarios);
        $('#idEnc').val(idEnc);
        $('#idDet').val(idDet);
        $('#modificar').modal();

        $("#monto").attr({
        "max" : monto,        
        "min" : 0          
        });
    }
</script>


  <!-- Modal -->
  <div class="modal fade" id="modificar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Modificar Cartera</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('cotizazcion.update')}}" method="POST">
        @csrf
        @method('put')
        <div class="modal-body">  
                <input type="hidden" name="idEnc" id="idEnc">
                <input type="hidden" name="idDet" id="idDet">
                <div class="row">
                    <div class="col-6">
                        <label>Monto Cotización</label>
                        <input type="number" step="0.000000001" required min="0" name="monto" class="form-control" id="monto">
                    </div>
                    <div class="col-6">
                        <label>Tasa Cotización</label>
                        <input type="number" step="0.000000001" required min="0" name="tasa" id="tasa" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Industria</label>
                        <input type="text" name="industria" class="form-control" id="industria">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label>comentarios</label>
                        <input type="text" name="comentarios" class="form-control" id="comentarios" cols="15" rows="5">
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
        </form>

      </div>
    </div>

  </div>









    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <br>
    <div class="row">
        <div style="background-color: white"
            class="ml-md-5 col-xs-12 table-responsive table-responsive col-md-9 rounded-lg mb-5">
            
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
                        <input type="text" readonly  class="numero" value="{{number_format($enc->tasa_ponderada, 2, '.') }}">
                    </div>
                    <div class="col-md-6">
                        <label>Plazo Promedio Ponderado (Días)</label>
                        <input type="text" readonly  class="numero" value="{{number_format($enc->dias_ponderados, 2, '.')}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5"></div>
                </div>
                
            

            
            <table style="text-align:center;" with="100%" class="w-100" id="tabla-cot">
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
                        @if ($enc->estado_cot=="A")
                            <th style="color: white">Accción</th>
                        @endif
                    </tr>
                </thead>
                
                <tbody>
                    @foreach ($det as $detalles)
                    
                        <tr class="tbh">
                            <td class="bl">{{$detalles->id_cotizacion}}</td>
                            <td class="bl">{{ $detalles->nombre_deudor }}</td>
                            <td class="bl">${{ number_format($detalles->monto_cot, 2, '.', ',' ) }}</td>
                            <td class="bl">{{ number_format(($detalles->tasa_cot-1.5), 2, '.' ) }}%</td>
                            <td class="bl">{{ substr($detalles->fecha_cot, 0, -8) }}</td>
                            <td class="bl">{{ $detalles->grupo_economico }}</td>
                            <td class="bl" >{{$detalles->pais}}</td>
                            <td class="blr" >{{$detalles->industria}}</td>
                            @if ($enc->estado_cot=="A")
                                <td  style="border-block-color: white">
                                    <input type="image" class="rounded-pill" height="40" width="40" 
                                    src="{{asset('assets/img/up.png')}}" onclick="editar({{$detalles->id_credito}},{{$detalles->id_cotizacion}},{{$detalles->monto_cot}}, {{$detalles->tasa_cot}}, '{{$detalles->comentarios}}', '{{$detalles->industria}}')"  />
                                    <input type="image" class="rounded-pill" height="40" width="40" 
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
                    <th class="h">{{number_format($enc->tasa_ponderada, 2)}}</th>
                    <th class="h">-</th>
                    <th class="h">-</th>
                    <th class="h">-</th>
                    <th class="h">-</th>
                    
                    
                </tr>
            </table>
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

@endsection

@section('scripts')
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
