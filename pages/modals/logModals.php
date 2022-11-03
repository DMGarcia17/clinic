<!-- Add or modify modal -->
<div class="modal fade" id="addSummary" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addSummaryLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSummaryLabel">Add / Modify Record</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addSummary">
          <div class="form-group">
            <label for="file">File</label>
            <select name="file" id="fileName" class="form-control" required>
              <?php
                $db = new DatabaseConnection();

                $res = $db->filtered_query("files", "ID, name", "name is not null and trim(name) != ''");
                foreach($res as $r){
                  echo '<option value="'.$r['ID'].'">'.$r['name'].'</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="registrationDate">Date & Time</label>
            <input type="datetime-local" name="registrationDate" id="registrationDate" class="form-control">
          </div>
          <div class="form-group">
            <label for="details">Details</label>
            <input type="text" name="details" id="details" class="form-control">
          </div>
          <input type="hidden" name="summaryId" id="summaryId">
          <div class="form-group">
            <label for="state">Extension</label>
            <select name="state" id="state" class="form-control" required>
              <?php
                $db = new DatabaseConnection();

                $res = $db->blankect_query('states', '*');
                foreach($res as $r){
                  echo '<option value="'.$r['state'].'">'.$r['description'].'</option>';
                }
              ?>
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancel</button>
        <button type="button" class="btn btn-primary" onClick="saveDl()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delDl" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delDlLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delDlLabel">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDlDel" id="idDlDel">
        <p>Are you sure you want to delete the record?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onClick="deleteDl($('#idDlDel').val())">Delete</button>
      </div>
    </div>
  </div>
</div>