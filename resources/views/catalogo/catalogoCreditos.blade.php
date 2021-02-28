@extends('layouts.master')

@section('title', 'Catalogo de Créditos')


@section('content')
    <div class="row">
        <div class="col-12">
            <br>
        </div>
    </div>
    <div class="row">
        <div style="background-color: white"
            class="ml-md-5 col-xs-12 table-responsive table-responsive col-md-9 rounded-lg mb-5">
            <form action="{{ route('catalogo-creditos.post') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="mayorA">Monto disponible mayor a</label>
                        <input type="number" name="mayorA" class="numero" id="mayorA" value="{{ $mayorA }}" autofocus
                            required>
                        <span class="text-danger">
                            @error('mayorA')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="menorA">Menor a</label>
                        <input type="number" name="menorA" class="numero" id="menorA" value="{{ $menorA }}" required>
                        <span class="text-danger">
                            @error('menorA')
                                {{ $message }}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <center>
                            <button class="filtrar">Filtrar</button>
                        </center>
                    </div>
                    <div class="col-md-5"></div>
                </div>
            </form>
            <br>
            <table with="100%" class="w-100 table-hover tabla" id="tabla-catalogo">
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
                            <td scope="row">{{ $catalogos->nombre_deudor }}</td>
                            <td>{{ $catalogos->NLP }}</td>
                            <td>{{ $catalogos->costo_ponderado }}</td>
                            <td>{{ $catalogos->fecha_vencimiento }}</td>
                            <td>{{ $catalogos->grupo_economico }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-2 col-xs-12 bg-naranja">
            <div class="menu-1">

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
