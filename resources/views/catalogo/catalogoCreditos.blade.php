@extends('layouts.master')

@section('title','Catalogo de Créditos')

@section('content')
    {{-- <h3>Aquí se muestran los creditos</h3>
    
    <ul>
        @foreach ($catalogo as $catalogos)
            <li>
                {{$catalogos->nombre_deudor}}
            </li>
        @endforeach
    </ul>

    {{$catalogo->links()}} --}}

    <div class="grid grid-cols-12 mt-20">
        <div class="bg-green-300 text-center rounded-full col-start-2 col-span-3"><p class="mt-4">Deudor</p></div>
        <div class="bg-green-300 text-center rounded-full">Monto disponible hasta por</div>
        <div class="bg-green-300 text-center rounded-full"><p class="mt-4">Tasa %</p></div>
        <div class="bg-green-300 text-center rounded-full"><p class="mt-4">Vencimiento</p></div>
        <div class="bg-green-300 text-center rounded-full col-span-2"><p class="mt-4">Grupo/pais</p></div>
        <div class="bg-green-300 text-center rounded-full col-span-2"><p class="mt-4">Giro de negocio</p></div>
    </div>
    @foreach ($catalogo as $catalogos)
        
    <div class="grid grid-cols-12 mt-1">
        <div class="bg-gray-200 text-center rounded-full col-start-2 col-span-3">{{$catalogos->nombre_deudor}}</div>
        <div class="bg-gray-200 text-center rounded-full">{{$catalogos->NLP}}</div>
        <div class="bg-gray-200 text-center rounded-full">{{$catalogos->costo_ponderado}}</div>
        <div class="bg-gray-200 text-center rounded-full">{{$catalogos->fecha_vencimiento}}</div>
        <div class="bg-gray-200 text-center rounded-full col-span-2">{{$catalogos->grupo_economico}}</div>
        <div class="bg-gray-200 text-center rounded-full col-span-2">Giro de negocio</div>
    </div>
        
    @endforeach
    {{$catalogo->links()}} --}}
@endsection