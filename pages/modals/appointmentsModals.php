<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
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
            <label for="prescribed">Medicamentos recetados</label>
            <textarea name="prescribed" id="prescribed" autocomplete="off" class="form-control" rows="3" disabled></textarea>
          </div>
          <div class="form-group">
            <label for="reason">Motivo de la Consulta</label>
            <input type="text" name="reason" id="reason" autocomplete="off" class="form-control">              
          </div>
          <div class="form-group">
            <label for="comments">Caracteristicas Cl&iacute;nicas y Radiograficas</label>
            <input type="text" name="comments" id="comments" autocomplete="off" class="form-control">
          </div>
          <div class="form-group">
            <label for="systemicDiagnosis">Enfermedades Sistemicas</label>
            <input type="text" name="systemicDiagnosis" id="systemicDiagnosis" class="form-control">
          </div>
          <div class="form-group">
            <label for="diagnosisResume">Diagnostico Bucal</label>
            <input type="text" name="diagnosisResume" id="diagnosisResume" class="form-control" autocomplete="off">
          </div>
          <div class="form-group select2-blue">
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
        <h5 class="modal-title" id="delLabel">Eliminar Consulta M&eacute;dica</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta consulta m&eacute;dica?</p>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetOnClose()">
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
        <button type="button" class="btn btn-default" data-dismiss="modal" onClick="resetOnClose()">Cerrar</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetMedicineForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addMedicineForm">
      <div class="modal-body">
          <div class="form-group">
            <label for="medicine">Medicamento</label><br>
            <input type="text" name="medicine" id="medicine" class="form-control" autocomplete="off">
          </div>
          <input type="hidden" name="idMpp" id="idMpp">
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
                  <button type="button" class="btn btn-primary" onClick="showAuth1Modal($('#idMDAppointment').val(), $('#idMDPatient').val())">Abrir</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9"><span>Consentimiento Informado Para Tratamientos Odontol&oacute;gicos</span></div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary" onClick="showAuth2Modal($('#idMDAppointment').val(), $('#idMDPatient').val())">Abrir</button>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-9">Periodontograma</div>
                <div class="col-md-3">
                  <button type="button" class="btn btn-primary" <?php echo 'onClick="window.location.href = \'http://'.host.'/clinic/periodontal/index.php?id=\'+$(\'#idMDPatient\').val()"' ?> >Abrir</button>
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


<!-- Fill data for intervention large modal -->
<div class="modal fade" id="auth1" data-backdrop="static" data-keyboard="false" aria-labelledby="auth1Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="auth1Label">Llenado de datos para "CONSENTIMIENTO INFORMADO PARA LA PRACTICA DE TRATAMIENTOS ODONTOLOGICOS, E INTERVENCIONES QUIRÚRGICAS Y/O PROCEDIMIENTOS ESPECIALES"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="auth1Form" method="post" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="odontoAuth1">Nombre del Odontologo(a)</label>
          <input type="text" name="odontoAuth1" id="odontoAuth1" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="procedures">Procedimientos a aplicar</label>
          <input type="text" name="procedures" id="procedures" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="prognosis">Pron&oacute;stico</label>
          <select type="text" name="prognosis" id="prognosis" class="form-control" autocomplete="off">
            <option value="B">Bueno</option>
            <option value="R">Regular</option>
            <option value="M">Malo</option>
          </select>
        </div>
        <div class="form-group">
          <label for="generalRisk">Riesgos Generales</label>
          <input type="text" class="form-control" name="generalRisk" id="generalRisk" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="specificRisk">Riesgos Específicos</label>
          <input type="text" class="form-control" name="specificRisk" id="specificRisk" autocomplete="off">
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


<!-- Fill data for Consent small modal -->
<div class="modal fade" id="auth2" data-backdrop="static" data-keyboard="false" aria-labelledby="auth2Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="auth2Label">Llenado de datos para "CONSENTIMIENTO INFORMADO PARA LA PRACTICA DE TRATAMIENTOS ODONTOL&Oacute;GICOS"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="auth2Form" method="post" action="">
      <div class="modal-body">
        <div class="form-group">
          <label for="odontoAuth2">Nombre del Odontologo(a)</label>
          <input type="text" name="odontoAuth2" id="odontoAuth2" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="cop">COP</label>
          <input type="text" name="cop" id="cop" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="proceduresAuth2">Procedimientos a aplicar</label>
          <input type="text" name="proceduresAuth2" id="proceduresAuth2" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="descProcedures">Descripci&oacute;n de los procedimientos a aplicar</label>
          <input type="text" name="descProcedures" id="descProcedures" class="form-control" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="benefits">Beneficios del Tratamiento</label>
          <input type="text" class="form-control" name="benefits" id="benefits" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="consequences">En caso de no realizar el tratamiento, las consecuenias ser&aacute;n</label>
          <input type="text" class="form-control" name="consequences" id="consequences" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="specificRiskAuth2">Riesgos del Tratamiento</label>
          <input type="text" class="form-control" name="specificRiskAuth2" id="specificRiskAuth2" autocomplete="off">
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