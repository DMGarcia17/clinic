<!-- Add or modify modal -->
<div class="modal fade" id="payments" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="paymentsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentsLabel">Archivos del Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetPayments()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="paymentsTable" area-label="Payments table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tratamiento realizado</th>
                        <th>Total</th>
                        <th>Pendiente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetPayments()">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delPayments" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delPaymentsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delPaymentsLabel">Eliminar Cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelPayments" id="idDelPayments">
        <p>¿Esta usted seguro que desea eliminar este cargo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delPayment($('#idDelPayments').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>