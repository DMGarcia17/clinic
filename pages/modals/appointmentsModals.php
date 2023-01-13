<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="visitedOn">ID del paciente</label>
                <input type="text" name="patient" id="patient" class="form-control">
                <button type="button" class = "btn btn-primary mt-4" onClick="findName($('#patient').val())">Buscar</button>
              </div>
            </div>
            <div class="col-md-4">
            </div>
          </div>
          <div class="form-group">
            <label for="name">Nombre del paciente</label>
            <input type="text" name="name" id="name" autocomplete="off" class="form-control" disabled>
          </div>
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="visitedOn">Fecha de la visita</label>
            <input type="datetime-local" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d').'T'.date('H').':'.date('i'); ?>" name="visitedOn" id="visitedOn" autocomplete="off" class="form-control" disabled>              
          </div>
          <div class="form-group">
            <label for="reason">Motivo de la visita</label>
            <input type="text" name="reason" id="reason" autocomplete="off" class="form-control">              
          </div>
          <div class="form-group">
            <label for="comments">Observaciones</label>
            <input type="text" name="comments" id="comments" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="diagnosisResume">Diagnostico</label>
            <input type="text" name="diagnosisResume" id="diagnosisResume" autocomplete="off" class="form-control">
          </div>
          <div class="form-group select2-purple">
            <label for="treatmentField">Mostrar en receta</label><br>
            <select name="treatmentField" id="treatmentField" class="select2 select2-hidden-accessible" style="width: 100%;" multiple>

              <?php
                $db = new DatabaseConnection();

                $res = $db->blankectOQuery("treatments", "cod_treatment, name", "pr_order asc");
                foreach($res as $r){
                  echo '<option value="'.$r['cod_treatment'].'">'.$r['name'].'</option>';
                  //echo '<div class="row">';
                }


              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="description">Descripci&oacute;n del tratamiento</label>
            <input type="text" name="description" id="description" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="disabilityDays">Días de incapacidad</label>
            <input type="text" name="disabilityDays" id="disabilityDays" autocomplete="off" class="form-control">
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
        <h5 class="modal-title" id="delLabel">Eliminar Tratamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta tratamiento?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>