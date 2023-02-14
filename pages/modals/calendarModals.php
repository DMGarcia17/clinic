<!-- Add or modify modal -->
<div class="modal fade" id="addVisit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="$('#addVisitForm').trigger('reset')">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addVisitForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="namev" id="nameLabel">Nombre del paciente</label>
            <input type="text" name="namev" id="namev" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="id" autocomplete="off" id="id">
          <input type="hidden" name="eventType" autocomplete="off" id="eventType">
          <div class="form-group">
            <label for="startv">Hora de inicio</label>
            <input type="datetime-local" name="startv" id="startv" autocomplete="off" class="form-control">              
          </div>
          <div class="form-group">
            <label for="endv">Hora de fin</label>
            <input type="datetime-local" name="endv" id="endv" autocomplete="off" class="form-control">
          </div>
      </div>
      <div class="modal-footer">
        <div style="width: 100%;">
          <div class="float-left">
            <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="deleteEvent()">Eliminar</button>
          </div>
          <div class="float-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="$('#addVisitForm').trigger('reset')">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Guardar</button>
          </div>
        </div>
      </div>
      
      </form>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="del" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delLabel">Eliminar Alergia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta alergia?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>