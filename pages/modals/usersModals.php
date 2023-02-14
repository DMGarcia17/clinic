<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="completeName">Nombre Completo</label>
            <input type="text" name="completeName" id="completeName" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="username">Nombre de usuario</label>
            <input type="text" name="username" id="username" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Contrase&ntilde;a</label>
            <input type="password" name="password" id="password" autocomplete="off" class="form-control">
            <small class="form-text text-muted">Si llena este campo se cambiara la contrase&ntilde;a del usuario</small>
          </div>
          <div class="form-group">
            <label for="defaultClinic">Cl&iacute;nica por defecto</label>
            <select name="defaultClinic" id="defaultClinic" class="form-control">
              <?php
                $db = new DatabaseConnection();

                $res = $db->blankectOQuery("clinics", "cod_clinic ID, clinic_name", "clinic_name asc");
                foreach($res as $r){
                  echo '<option value="'.$r['ID'].'">'.$r['clinic_name'].'</option>';
                }
              ?>
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
        <h5 class="modal-title" id="delLabel">Eliminar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idUserDel" id="idUserDel">
        <p>¿Esta usted seguro que desea eliminar este usuario?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delUser($('#idUserDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>