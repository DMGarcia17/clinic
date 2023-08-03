<!-- Add or modify modal -->
<div class="modal fade" id="payments" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="paymentsLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="paymentsLabel">Saldos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div style="margin: 2vw;">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="paymentsTable" area-label="Payments table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Detalle</th>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Add or modify modal -->
<div class="modal fade" id="payData" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="payDataLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payDataLabel">Abonos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetPayData()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <input type="hidden" name="idInvoice" id="idInvoice">
      <input type="hidden" name="totalAmount" id="totalAmount">
      <div style="margin: 2vw;">
        <div class="row">
          <div class="col-md-12">
            <h5>Restante a pagar: <span id="debit"></span></h5>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="payDataTable" area-label="payData table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Abono</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetPayData()">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delPaymentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delPaymentLabel">Eliminar Cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelPayment" id="idDelPayment">
        <p>¿Esta usted seguro que desea eliminar este cargo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delPayment($('#idDelPayment').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete modal -->
<div class="modal fade" id="delInvoice" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delInvoiceLabel">Eliminar Cargo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelInvoice" id="idDelInvoice">
        <p>¿Esta usted seguro que desea eliminar este cargo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delInvoice($('#idDelInvoice').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editPaymentLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPaymentLabel">Editar / Guardar Abono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetPayDataForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="editPaymentForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="amountPayment">Cantidad a abonar</label>
            <input type="number" name="amountPayment" id="amountPayment" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="idPayment" id="idPayment">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetPayDataForm()">Cancelar</button>
        <button type="submit" class="btn btn-primary" >Guardar</button>
      </div>
      
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="editInvoice" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editInvoiceLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editInvoiceLabel">Editar / Guardar Abono</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetPayDataForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="editIForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="treatmentDesc">Descripción del tratamiento</label>
            <input type="text" name="treatmentDesc" id="treatmentDesc" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="amountInvoice">Cantidad a abonar</label>
            <input type="number" name="amountInvoice" id="amountInvoice" autocomplete="off" class="form-control">
          </div>
          <input type="hidden" name="idInvoiceField" id="idInvoiceField">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetPayDataForm()">Cancelar</button>
        <button type="submit" class="btn btn-primary" >Guardar</button>
      </div>
      
      </form>
    </div>
  </div>
</div>