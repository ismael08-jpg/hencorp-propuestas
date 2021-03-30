@extends('layouts.master')

@section('title', 'Admin')

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

@section('menu')
    @include('layouts.nav')
@endsection


@section('content')
    
<script>
    
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
        </div>
        
        <div style="height: 80%" class="col-md-2 col-xs-12 rounded-lg ml-2  bg-white d-flex flex-column align-items-center">
            <div>
                <div class="menu-1 mt-5 ">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit"  class="btn btn-round btn-azul" value="Cerrar sesión">
                    </form>
                    {{-- <a href="#" class="btn mb-5 btn-round btn-naranja mt-2" name="btnPropuesta">Enviar</a> --}}
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
        

    </script>
@endsection

