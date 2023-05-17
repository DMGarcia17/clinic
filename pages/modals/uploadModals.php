<!-- Add or modify modal -->
<div class="modal fade" id="upload" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="uploadLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="uploadLabel">Archivos del Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetUpload()">
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
                    <input type="file" name="fileUpload" id="fileUpload" required autocomplete="off" class="form-control">
                    <input type="hidden" name="idApp" id="idApp" value="">
                    <input type="hidden" name="idPatient" id="idPatient">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div id="progress-bar"></div>
                </div>
                <div id="targetLayer"></div>
              </div>
              
            <button type="button" class="btn btn-secondary" onClick="resetUpload()">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Guardar</button>
          </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="uploadFiles" area-label="Files table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Archivo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetUpload()">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delUpload" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delUploadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delUploadLabel">Eliminar Archivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelUpload" id="idDelUpload">
        <input type="hidden" name="nameDelUpload" id="nameDelUpload">
        <p>¿Esta usted seguro que desea eliminar este archivo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delUpload($('#idDelUpload').val(), $('#nameDelUpload').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>