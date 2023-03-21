<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Add / Modify Clinic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="name">Nombre de la enfermedad</label>
            <input type="text" name="name" id="name" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="description">Descripci&oacute;n de la enfermedad</label>
            <input type="text" name="description" id="description" autocomplete="off" class="form-control">              
          </div>
          <div class="form-group">
            <label for="order">Orden de visualizaci&oacute;n</label>
            <input type="text" name="order" id="order" autocomplete="off" class="form-control">
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
        <h5 class="modal-title" id="delLabel">Eliminar Enfermedad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta enfermedad?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="upload" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadLabel">Archivos del Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="container-fluid">
        <form id="uploadForm" action="../Controllers/UploadController.php" enctype="multipart/form-data" method="post">
          <div class="modal-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="fileUpload">Archivo</label>
                    <input type="file" name="fileUpload" id="fileUpload" accept=".xlsx" required autocomplete="off" class="form-control">
                    <input type="hidden" name="function" id="function" value="bl">
                  </div>
                </div>
              </div>
              
            <button type="button" class="btn btn-secondary" onClick="resetForm()">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Guardar</button>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cerrar</button>
      </div>
    </div>
  </div>
</div>