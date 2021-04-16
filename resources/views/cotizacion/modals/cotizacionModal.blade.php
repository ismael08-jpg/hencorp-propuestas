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
                        <label>Rendimiento (%)</label>
                        <input type="number" step="0.000000001" required min="0" name="rendimiento" id="rendimiento" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>País</label>
                        <input type="text" name="pais" class="form-control" id="pais">
                    </div>
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


