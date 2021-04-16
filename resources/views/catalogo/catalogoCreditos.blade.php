@extends('layouts.master')

@section('title', 'Catalogo de Créditos')

@section('styles')
    <style>
        
        .tabla,
        th,
        td,
        tr {
            border: 2px solid #0684fc;
            text-align: center;
        }

        .tabla,
        td {
            background-color: white;
            color: black;
        }

        .tabla,
        th {
            background-color: #02163a;
            color: white;
            
        }
    </style>
    
@endsection

@section('menu')
    @include('layouts.nav')
@endsection

@section('content')

    
<div class="modal fade" id="config" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content ">
        <div class="modal-header ">
          <h5 class="modal-title" id="exampleModalLongTitle">Configuración</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('config.update')}}" method="POST">
            @csrf
            @method('put')
            <div class="modal-body">          
                    <div class="row">
                        <div class="col-6">
                            <label>Rendimiento HBC</label>
                            <input type="number" step="0.0001" min="0.00000" value="{{$parametro->rendimiento_hbc}}" name="rendimientohbc" class="form-control" id="rendimientohbc" cols="15" rows="5">
                        </div>
                        <div class="col-6">
                            <label>Fecha cartera</label>
                            <input type="text" disabled  value="{{$fechaCartera}}" name="rendimientohbc" class="form-control" id="rendimientohbc" cols="15" rows="5">
                        </div>         
                    </div>
                    <input type="hidden" value="{{$parametro->id_config}}" name="id">
            </div>
            <div class="modal-footer">
            @if (Auth::user()->tipo_usuario == 1)
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Actualizar</button>
            @else
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            @endif
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
        <div style="background-color: white; "
            class="ml-md-5 col-xs-12 table-responsive col-md-9 rounded-lg mb-5">
            
            <div class="d-flex flex-row-reverse">
                <div class="p-3 mt-2">
                    <input type="image" id="configure" onclick="$('#config').modal();" height="20px" width="20px" 
                    src="{{asset('assets/img/engranaje.png')}}">
                </div>
            </div>
            
            <form action="{{ route('catalogo-creditos.post') }}" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Participante Actual</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Nuevo Participante</a>
                            </li>
                            
                        </ul>

                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <br>
                                <select name="parti"  id="participantes" class="numero" value='{{$parti}}'>
                                    @if ($parti!=null)
                                        <option value="{{$parti}}">{{$parti}}</option>
                                    @endif
                                    @foreach ($participante as $participantes)
                                        <option value="{{$participantes->nom_participante}}">{{$participantes->nom_participante}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">
                                    @error('participante')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <br>
                                <input type="text" class="txt-parti" disabled  name="parti" id="nuevoParti" placeholder="Nombre del nuevo participante">
                            </div>
                           
                        </div>

                        
                    </div>
                    
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <center><label class="mayorA">Monto por invertir</label></center>
                        <input type="number" step="0.01"  name="monto" class="numero" id="monto" value="{{old('monto', $monto)}}" autofocus
                            required>
                        <span class="text-danger">
                            @error('monto')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-3">
                        <center><label class="mayorA">Monto mayor a</label></center>
                        <input type="number" step="0.01"  name="mayorA" class="numero" id="mayorA" value="{{old('mayorA', $mayorA)}}">
                        <span class="text-danger">
                            @error('mayorA')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-3">
                        <center><label class="mayorA">Monto menor a</label></center>
                        <input type="number" step="0.01"  name="menorA" class="numero" id="menorA" value="{{old('menorA', $menorA)}}">
                        <span class="text-danger">
                            @error('menorA')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    
                </div>
                <br>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <center>
                            <button  class="filtrar" id="fill" type="submit" name="filtrar" value="filter">Filtrar</button>
                        </center>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>                
            </form>

            
            <table with="100%" style="" class="w-100 table-hover tabla" id="tabla-catalogo">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th scope="col">Deudor</th>
                        <th scope="col">Monto disponible hasta por</th>
                        <th scope="col">Rendimiento (%)</th>
                        <th scope="col">Vencimiento</th>
                        <th>Grupo</th>
                        <th>País</th>
                        <th>Industria</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($inversionesDisponibles as $catalogos)
                        <tr>
                            <td>{{$catalogos['id']}}</td>
                            <td scope="row">{{ $catalogos['nombre_deudor'] }}</td>
                            <td>${{ number_format($catalogos['NLP'], 2, '.', ',' ) }}</td>
                            @if ($catalogos['tasa_credito']>0 and $catalogos['tasa_credito']<=1.5)
                                <td>0%</td>
                            @else
                                <td>{{ number_format(($catalogos['tasa_credito']-1.5), 2, '.', ',' )  }}%</td>
                            @endif
                            <td>{{ substr($catalogos['fecha_vencimiento'], 0, -8) }}</td>
                            <td>{{ $catalogos['grupo_economico'] }}</td>
                            <td>{{$catalogos['pais']}}</td>
                            <td>{{$catalogos['industria']}}</td>
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
                    <a href="{{route('propuestas.index')}}" class="btn mb-3 btn-round btn-griz mt-2" name="btnPropuesta">Mis propuestas</a>
                    <form action="{{ route('catalogo-creditos.post') }}" method="POST" >
                        @csrf
                        <?php 
                    
                            if($bandera == 1){   
                                if ($saldoParti->saldo==null)
                                $saldoParti->saldo=0;

                                $montoTotal = $saldoParti->saldo + $monto;
                        
                                echo " <button class='btn btn-round btn-naranja  mb-5'  type='submit' name='save'>Guardar</button>
                                    <input type='hidden' class='numero' name='partiInput' value='$parti'>     
                                    <input type='hidden' name='montoTotal' value='$montoTotal'>
                                    <input type='hidden' name='montoInput' value='$monto'>
                                    <input type='hidden' name='saldo' value='$saldoParti->saldo'>
                                   
                                     ";
                            }
                    ?>
                    
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center p-4" style="color:#fff">
        <span>&copy <span id="cr-year"></span> AS Analytics. Todos los derechos reservados.</span>
    </div>
@endsection

@section('scripts')

    @if ($bandera==1)
        <script type="text/javascript">
            var toast = new Toasty();

            toast.success("Propuesta generada con éxito");
        </script>
    @endif

    <script type="text/javascript">
    

    const botonFiltar = document.querySelector("#fill");
    botonFiltar.addEventListener("click", () =>{
        
    });
        
        $(document).ready(function() {
            $('#tabla-catalogo').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Carteras",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No hay carteras para el rango",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                'pageLength' : 15,
                'lengthMenu' : [15, 25, 40],
                "ordering": false
            });

            $('#participantes').select2();

            $( "#profile-tab" ).click(function() {
               $('#participantes').attr("disabled", true);
               $('#nuevoParti').attr("disabled", false);
            });
            $( "#home-tab" ).click(function() {
               $('#participantes').attr("disabled", false);
               $('#nuevoParti').attr("disabled", true);
            }); 

            
        });
        
        

        
    </script>
@endsection
