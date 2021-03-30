@extends('layouts.master')

@section('title', 'Enviar Cotizacion')

@section('styles')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js" integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw==" crossorigin="anonymous"></script> --}}
@endsection
    


@section('content')
    


    <div class="row">
        <div class="col-12">
        </div>
    </div>
    <br>
    <div class="row">
        <div style="background-color: white; " class="ml-md-5 col-xs-12 table-responsive col-md-9 rounded-lg mb-5"> 
            <form action="{{ route('cotizacion.enviar') }}" method="POST">
                @csrf
                <div class="container-fluid ">
                    <div class="row">
                        <div class="col-md-12 mt-5">
                            <label>Correo electronico</label>
                            <input type="email" required placeholder="someone@something.com" name="correo" class="numero">
                        </div>
                        <div>

                            <input readonly type="hidden"  value="{{$id}}" name="id" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            
                        </div>
                        <div class="col-md-6">
                
                        </div>
                    </div>
                    <div class="d-flex w-100 justify-content-center mt-5 mb-5">
                        <button type="submit" name="enviar" value="enviar" class="btn btn-info mr-4 ">Enviar por correo</button>
                        <button type="submit" name="ver" value="revisar" class="btn btn-naranja">Visualizar PDF</button>
                    </div>
    
                </div>
            </form>            
        </div>




        <div style="height:70%" class="col-md-2 col-xs-12 rounded-lg ml-2 bg-white d-flex flex-column align-items-center">
            <div>
                <div class="menu-1 mt-5 ">
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" class="btn btn-round mb-3 btn-azul"  value="Cerrar sesión">
                    </form>
                    <a href="{{route('propuestas.index')}}" class="btn mb-3 btn-round btn-griz mt-2" name="btnPropuesta">Mis propuestas</a>
                    <br>
                    <a href="{{route('cotizacion.index', $id)}}" class="btn mb-3 btn-round btn-naranja mt-2" name="btnPropuesta">Regresar</a>
                    
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
        
    </script>
@endsection
