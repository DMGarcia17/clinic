<!-- Add or modify modal -->
<div class="modal fade" id="addClinic" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addClinicLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addClinicLabel">Add / Modify Clinic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addClinic">
          <div class="form-group">
            <label for="name">Nombre de la cl&iacute;nica</label>
            <input type="text" name="name" id="clinicName" class="form-control">
          </div>
          <input type="hidden" name="clinicId" id="clinicId">
          <div class="form-group">
            <label for="address">Direcci&oacute;n de la cl&iacute;nica</label>
            <input type="text" name="address" id="clinicAddress" class="form-control" required>
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
            <label for="phone">N&uacute;mero telef&oacute;nico</label>
            <input type="text" name="phone" id="clinicPhone" class="form-control">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancel</button>
        <button type="button" class="btn btn-primary" onClick="saveClinic()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delClinic" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delClinicLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delClinicLabel">Eliminar Cl&iacute;nica</h5>
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