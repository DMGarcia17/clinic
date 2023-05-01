<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="visitedOn">ID del paciente</label>
                <input type="text" name="patient" id="patient" class="form-control">
                <button type="button" class = "btn btn-primary mt-4" onClick="findName($('#patient').val())">Buscar</button>
              </div>
            </div>
            <div class="col-md-4">
            </div>
          </div>
          <div class="form-group">
            <label for="name">Nombre del paciente</label>
            <input type="text" name="name" id="name" autocomplete="off" class="form-control" disabled>
          </div>
          <input type="hidden" name="id" id="id">
          <div class="form-group">
            <label for="visitedOn">Fecha de la visita</label>
            <input type="datetime-local" value="<?php echo date('Y') . '-' . date('m') . '-' . date('d').'T'.date('H').':'.date('i'); ?>" name="visitedOn" id="visitedOn" autocomplete="off" class="form-control" disabled>              
          </div>
          <div class="form-group">
            <label for="reason">Motivo de la visita</label>
            <input type="text" name="reason" id="reason" autocomplete="off" class="form-control">              
          </div>
          <div class="form-group">
            <label for="comments">Observaciones</label>
            <input type="text" name="comments" id="comments" autocomplete="off" class="form-control">
          </div>
          <div class="form-group select2-purple">
            <label for="diagnosisResume">Diagnostico</label>
            <!-- <input type="text" name="diagnosisResume" id="diagnosisResume" autocomplete="off" class="form-control"> -->
            <select name="diagnosisResume" id="diagnosisResume" class="select2 select2-hidden-accessible" style="width: 100%;" multiple>

              <?php
                $db = new DatabaseConnection();

                $res = $db->blankectOQuery("diseases", "cod_disease, name", "pr_order asc");
                foreach($res as $r){
                  echo '<option value="'.$r['cod_disease'].'">'.$r['name'].'</option>';
                  //echo '<div class="row">';
                }


              ?>
            </select>
          </div>
          <div class="form-group select2-purple">
            <label for="treatmentField">Tratamientos</label><br>
            <select name="treatmentField" id="treatmentField" class="select2 select2-hidden-accessible" style="width: 100%;" multiple>

              <?php
                $db = new DatabaseConnection();

                $res = $db->blankectOQuery("treatments", "cod_treatment, name", "pr_order asc");
                foreach($res as $r){
                  echo '<option value="'.$r['cod_treatment'].'">'.$r['name'].'</option>';
                  //echo '<div class="row">';
                }


              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="description">Descripci&oacute;n del tratamiento</label>
            <input type="text" name="description" id="description" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="disabilityDays">Días de incapacidad</label>
            <input type="text" name="disabilityDays" id="disabilityDays" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="nextAppointment">Fecha de la siguiente visita</label>
            <input type="datetime-local" name="nextAppointment" id="nextAppointment" autocomplete="off" class="form-control">              
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
        <h5 class="modal-title" id="delLabel">Eliminar Tratamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta tratamiento?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addPr" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addPrLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPrLabel">Agregar / Modificar Receta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container p-3">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" name="idAppointment" id="idAppointment">
              <table class="table table-bordered table-stripped" id="prescriptions">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad de Medicamentos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="addMedicines" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addMedicinesLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMedicinesLabel">Agregar / Modificar Medicamentos Recetados</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container p-3">
            <div class="row" id="prescriptionModal">
              <div class="col-md-12">
                  <form id="prescriptionForm">
                    <div class="form-group">
                      <label for="idPrescription">ID de la receta</label>
                      <input type="text" disabled name="idPrescription" id="idPrescription" autocomplete="off" class="form-control">
                    </div>
                    <button class="btn btn-primary float-sm-right" type="button" onClick="createNewPrescription();" id='createPr'>Crear receta</button>
                  </form>
              </div>
            </div>
            <div class="row" id="medicinesContainer">
              <div class="col-md-12">
                <table class="table table-bordered table-stripped" id="medicines">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Medicamento</th>
                          <th>Cantidad</th>
                          <th>Indicaci&oacute;n</th>
                          <th>Acciones</th>
                      </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-default">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Delete modal -->
<div class="modal fade" id="delPrescription" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delPrescriptionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delPrescriptionLabel">Eliminar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelPrescription" id="idDelPrescription">
        <p>¿Esta usted seguro que desea eliminar este medicamento de la receta?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delPrescription($('#idDelPrescription').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>


<!-- Add or modify modal -->
<div class="modal fade" id="addMedicine" data-backdrop="static" data-keyboard="false" aria-labelledby="addMedicineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMedicineLabel">Agregar / Modificar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addMedicineForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="medicine">Medicamento</label><br>
            <select name="medicine" id="medicine" class="select2" style="width: 100%;">
                <option value="">Seleccione un valor...</option>
              <?php
                $db = new DatabaseConnection();

                $res = $db->blankectOQuery("medicines", "cod_medicine, description", "cod_medicine asc");
                foreach($res as $r){
                  echo '<option value="'.$r['cod_medicine'].'">'.$r['description'].'</option>';
                  //echo '<div class="row">';
                }


              ?>
            </select>
          </div>
          <input type="hidden" name="idMpp" id="idMpp">
          <div class="form-group">
            <label for="amount">Cantidad</label>
            <input type="number" name="amount" autocomplete="off" id="amount" class="form-control">              
          </div>
          <div class="form-group">
            <label for="indication">Indicaci&oacute;n</label>
            <!-- <input type="text" name="indication" autocomplete="off" id="indication" class="form-control"> -->
            <textarea name="indication" autocomplete="off" id="indication" class="form-control" rows="10"></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancelar</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
      
      </form>
    </div>
  </div>
</div>


<!-- Delete modal -->
<div class="modal fade" id="delMedicine" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="delMedicineLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="delMedicineLabel">Eliminar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDelMedicine" id="idDelMedicine">
        <p>¿Esta usted seguro que desea eliminar este medicamento de la receta?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="delMedicine($('#idDelMedicine').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal for different documents to print -->
<div class="modal fade" id="prints" data-backdrop="static" data-keyboard="false" aria-labelledby="printsLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="printsLabel">Documentos Disponibles</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <input type="hidden" name="idMDAppointment" id="idMDAppointment">
        <input type="hidden" name="idMDPatient" id="idMDPatient">
        <input type="hidden" name="daysOff" id="daysOff">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9"><span>Constancia de Incapacidad</span></div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary" onClick="showIncapabilityModal($('#idMDAppointment').val(), $('#idMDPatient').val())">Abrir</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9"><span>Consentimiento informado para la practica de tratamientos odontologicos, e intervenciones quirúrgicas y/o procedimientos especiales</span></div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary" onClick='window.location.href = "http://localhost/clinic/pages/authorization.php?id="+$("#idMDAppointment").val()+"&p="+$("#idMDPatient").val();'>Abrir</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9"><span>Consentimiento Informado Para Tratamientos Odontol&oacute;gicos</span></div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary" onClick='window.location.href = "http://localhost/clinic/pages/consent.php?id="+$("#idMDAppointment").val()+"&p="+$("#idMDPatient").val();'>Abrir</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9">¿? Constancia de Visita</div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary">Abrir</button>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
      
    </div>
  </div>
</div>


<!-- Fill data for inability constance modal -->
<div class="modal fade" id="inability" data-backdrop="static" data-keyboard="false" aria-labelledby="inabilityLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inabilityLabel">Llenado de datos para constancia de incapacidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="inabilityForm" method="post" action="">
      <div class="modal-body">
          <div class="form-group">
            <label for="inabilityDays">Total de d&iacute;as de incapacidad</label>
            <input type="number" name="inabilityDays" id="inabilityDays" class="form-control" autocomplete="off">
          </div>
          <div class="form-group">
            <label for="cause">Motivo de la incapacidad</label>
            <input type="text" name="cause" id="cause" class="form-control" autocomplete="off">
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="resetForm()">Cancelar</button>
        <button type="submit" class="btn btn-primary">Aceptar</button>
      </div>
      
      </form>
    </div>
  </div>
</div>