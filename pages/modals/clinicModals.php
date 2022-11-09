<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Cl&iacute;nica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="clinicName">Nombre de la cl&iacute;nica</label>
            <input type="text" name="clinicName" id="clinicName" class="form-control">
          </div>
          <input type="hidden" name="clinicId" id="clinicId">
          <div class="form-group">
            <label for="clinicAddress">Direcci&oacute;n de la cl&iacute;nica</label>
            <input type="text" name="clinicAddress" id="clinicAddress" class="form-control">
              <?php
                /*require_once $base.'core/Connection.php';

                $db = new DatabaseConnection();

                $res = $db->blankect_query('clinic_extensions', '*');
                foreach($res as $r){
                  echo '<option value="'.$r['ID'].'">'.$r['extension'].'</option>';
                }*/
              ?>
          </div>
          <div class="form-group">
            <label for="clinicPhone">N&uacute;mero telef&oacute;nico</label>
            <input type="text" name="clinicPhone" id="clinicPhone" class="form-control">
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
        <h5 class="modal-title" id="delLabel">Eliminar Cl&iacute;nica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idClinicDel" id="idClinicDel">
        <p>¿Esta usted seguro que desea eliminar esta cl&iacute;nica?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="deleteClinic($('#idClinicDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>