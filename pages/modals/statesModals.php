<!-- Add or modify modal -->
<div class="modal fade" id="addState" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addStateLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStateLabel">Add / Modify State</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addState">
          <div class="form-group">
            <label for="state">State</label>
            <input type="text" name="state" id="state" class="form-control">
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <input type="text" name="description" id="description" class="form-control">
          </div>
          <input type="hidden" name="userAdd" id="userAdd">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancel</button>
        <button type="button" class="btn btn-primary" onClick="saveSt()">Save</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delSt" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delStLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delStLabel">Add / Modify State</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idStDel" id="idStDel">
        <p>Are you sure you want to delete the State?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onClick="deleteSt($('#idStDel').val())">Delete</button>
      </div>
    </div>
  </div>
</div>