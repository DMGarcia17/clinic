<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Pregunta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="question">Pregunta</label>
            <input type="text" name="question" id="question" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="pquestion">Pregunta Pedi&aacute;trica</label>
            <select name="pquestion" id="pquestion" class="form-control">
              <option value="S">Si</option>
              <option value="N">No</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancelar</button>
        <button type="submit" class="btn btn-primary" >Guardar</button>
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
        <h5 class="modal-title" id="delLabel">Eliminar Pregunta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta pregunta?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>