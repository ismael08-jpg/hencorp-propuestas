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
            
            <form action="{{ route('catalogo-creditos.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <center><label class="mayorA">Monto por invertir</label></center>
                        <input type="number" name="mayorA" class="numero" id="mayorA" value="{{ $monto }}" autofocus
                            required>
                        <span class="text-danger">
                            @error('mayorA')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6">
                        <center><label class="mayorA">Participante</label></center>
                        <select name="parti"  class="form-control" value='{{$parti}}'>
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
                    
                </div>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <center>
                            <button class="filtrar" type="submit" name="filtrar" value="filter">Filtrar</button>
                        </center>
                    </div>
                    <div class="col-md-5"></div>
                </div>
                <br>                
            </form>

            
            <table with="100%" style="text-align:center;" class="w-100 table-hover tabla" id="tabla-catalogo">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th scope="col">Deudor</th>
                        <th scope="col">Monto disponible hasta por</th>
                        <th scope="col">Tasa %</th>
                        <th scope="col">Vencimiento</th>
                        <th>Grupo/país</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($inversionesDisponibles as $catalogos)
                        <tr>
                            <td>{{$catalogos['id']}}</td>
                            <td scope="row">{{ $catalogos['nombre_deudor'] }}</td>
                            <td>${{ $catalogos['NLP'] }}</td>
                            <td>{{ $catalogos['tasa_credito']-1.5 }}%</td>
                            <td>{{ $catalogos['fecha_vencimiento'] }}</td>
                            <td>{{ $catalogos['grupo_economico'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-2 col-xs-12 rounded-lg ml-2 bg-white d-flex flex-column align-items-center">
            <div>
                <div class="menu-1 mt-5 ">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-round btn-azul" value="Cerrar sesión">
                    </form>
                    <form action="{{ route('catalogo-creditos.post') }}" method="POST" >
                        @csrf
                        <?php 
                    
                            if($bandera == 1){   
                                if ($saldoParti->saldo==null)
                                $saldoParti->saldo=0;

                                $montoTotal = $saldoParti->saldo + $monto;
                        
                                echo " <button class='btn btn-round btn-naranja mt-2' type='submit' name='save'>Guardar propuesta</button>
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
