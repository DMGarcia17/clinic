<!-- Add or modify modal -->
<div class="modal fade" id="addFile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addFileLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFileLabel">Add / Modify File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addFile">
          <div class="form-group">
            <label for="name">File Name</label>
            <input type="text" name="name" id="fileName" class="form-control">
          </div>
          <input type="hidden" name="fileId" id="fileId">
          <div class="form-group">
            <label for="extension">Extension</label>
            <select name="extension" id="fileExtension" class="form-control" required>
              <?php
                require_once $base.'core/Connection.php';

                $db = new DatabaseConnection();

                $res = $db->blankect_query('file_extensions', '*');
                foreach($res as $r){
                  echo '<option value="'.$r['ID'].'">'.$r['extension'].'</option>';
                }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancel</button>
        <button type="button" class="btn btn-primary" onClick="saveFile(files)">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delFile" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delFileLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delFileLabel">Add / Modify File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idFileDel" id="idFileDel">
        <p>Are you sure you want to delete the file?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onClick="deleteFile($('#idFileDel').val())">Delete</button>
      </div>
    </div>
  </div>
</div>