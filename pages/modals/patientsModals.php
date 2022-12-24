<!-- Add or modify modal -->
<div class="modal fade" id="add" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addLabel">Agregar / Modificar Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="resetForm()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form id="addForm">
      <div class="modal-body">
          <input type="hidden" name="id" id="id">
          <div class="row">
            <div class="col-md-12">
              <h3>Formulario para la Historia de Salud</h3>
              <h5>Informaci&oacute;n B&aacute;sica</h5>
              <hr>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="firstName">Primer Nombre</label>
                  <input type="text" name="firstName" id="firstName" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="secondName">Segundo Nombre</label>
                  <input type="text" name="secondName" id="secondName" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="firstSurname">Primer Apellido</label>
                  <input type="text" name="firstSurname" id="firstSurname" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="secondSurname">Segundo Apellido</label>
                  <input type="text" name="secondSurname" id="secondSurname" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="phoneNumber">Tel&eacute;fono de Casa</label>
                  <input type="text" name="phoneNumber" id="phoneNumber" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cellphoneNumber">Tel&eacute;fono Celular</label>
                  <input type="text" name="cellphoneNumber" id="cellphoneNumber" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label for="address">Direcci&oacute;n</label>
                  <input type="text" name="address" id="address" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="city">Ciudad</label>
                  <input type="text" name="city" id="city" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="state">Estado</label>
                  <input type="text" name="state" id="state" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="postalCode">Cod. Postal</label>
                  <input type="text" name="postalCode" id="postalCode" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="occupation">Ocupaci&oacute;n</label>
                  <input type="text" name="occupation" id="occupation" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="height">Estatura</label>
                  <input type="text" name="height" id="height" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="weight">Peso</label>
                  <input type="text" name="weight" id="weight" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="birthday">Fecha de Nacimiento</label>
                  <input type="date" name="birthday" id="birthday" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="gender">G&eacute;nero</label>
                  <select name="gender" id="gender" class="form-control">
                    <option value="F">Femenino</option>
                    <option value="M">Masculino</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="numIdPatient">ID o DUI del Paciente</label>
                  <input type="text" name="numIdPatient" id="numIdPatient" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h5>En caso de emergencia</h5>
              <hr>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="emergencyCall">Contacto de Emergencia</label>
                  <input type="text" name="emergencyCall" id="emergencyCall" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="related">Parentesco</label>
                  <input type="text" name="related" id="related" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="phoneEmergency">Tel&eacute;fono</label>
                  <input type="text" name="phoneEmergency" id="phoneEmergency" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="cellphoneEmergency">Tel&eacute;fono Celular</label>
                  <input type="text" name="cellphoneEmergency" id="cellphoneEmergency" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h5>Si usted esta llenando este formulario para otra persona, que parentesco tiene con esa persona?</h5>
              <hr>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="filledBy">Nombre</label>
                  <input type="text" name="filledBy" id="filledBy" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="relatedFb">Parentesco</label>
                  <input type="text" name="relatedFb" id="relatedFb" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h5>Informaci&oacute;n M&eacute;dica</h5>
              <hr>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="doctorsCare">Se encuentra ahora bajo el cuidado de un m&eacute;dico?</label>
                      <select name="doctorsCare" id="doctorsCare" class="form-control">
                        <option value="S">S&iacute;</option>
                        <option value="N">No</option>
                        <option value="NS">No S&eacute;</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="doctorsName">M&eacute;dico</label>
                      <input type="text" name="doctorsName" id="doctorsName" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="doctorsPhone">Tel&eacute;fono</label>
                      <input type="text" name="doctorsPhone" id="doctorsPhone" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="doctorsAddress">Direcci&oacute;n</label>
                      <input type="text" name="doctorsAddress" id="doctorsAddress" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="doctorsCity">Ciudad/Estado</label>
                      <input type="text" name="doctorsCity" id="doctorsCity" autocomplete="off" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="doctorsZip">C&oacute;digo</label>
                      <input type="text" name="doctorsZip" id="doctorsZip" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <label for="healthyPatient">Se encuentra usted sano/a?</label>
                      <select name="healthyPatient" id="healthyPatient" class="form-control">
                        <option value="S">S&iacute;</option>
                        <option value="N">No</option>
                        <option value="NS">No S&eacute;</option>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="stableHealth">Ha habido alg&uacute;n cambio en su salud generaldurante el &uacute;ltimo a&ntilde;o?</label>
                      <select name="stableHealth" id="stableHealth" class="form-control">
                        <option value="S">S&iacute;</option>
                        <option value="N">No</option>
                        <option value="NS">No S&eacute;</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="doctorsCondition">Si es as&iacute; qu&eacute; condici&oacute;n le esta trantando?</label>
                      <input type="text" name="doctorsCondition" id="doctorsCondition" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="examsDate">Fecha de &uacute;ltimo examen m&eacute;dico:</label>
                      <input type="date" name="examsDate" id="examsDate" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="pastYears">Ha tenido alguna enfermedad grave, operaci&oacute;n o ha sido hospitalizado/a en los &uacute;ltimos 5 a&ntilde;os?</label>
                      <select name="pastYears" id="pastYears" class="form-control">
                        <option value="S">S&iacute;</option>
                        <option value="N">No</option>
                        <option value="NS">No S&eacute;</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="diseasePast">Si es as&iacute; cual fue el problema?</label>
                      <input type="text" name="diseasePast" id="diseasePast" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="takenMedicine">Est&aacute; tomando o ha tomado recientemente alg&uacute;n medicamento recetado o sin receta?</label>
                      <select name="takenMedicine" id="takenMedicine" class="form-control">
                        <option value="S">S&iacute;</option>
                        <option value="N">No</option>
                        <option value="NS">No S&eacute;</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="medicine">Si es as&iacute;, por favor indique cu&aacute;les son, incluyendo vitaminas, preparados naturales, o a base de hierbas y/o suplementos diet&eacute;ticos:</label>
                      <input type="text" name="medicine" id="medicine" autocomplete="off" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            

            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="antibiotics">Le ha recomendado alg&uacute;n m&eacute;dico o su dentista anterior que tome antibi&oacute;ticos antes de su tratamiento dental?</label>
                  <select name="antibiotics" id="antibiotics" class="form-control">
                    <option value="S">S&iacute;</option>
                    <option value="N">No</option>
                    <option value="NS">No S&eacute;</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label for="antibioticsDoctor">Nombre del m&eacute;dico o dentista que se lo recomendo</label>
                  <input type="text" name="antibioticsDoctor" id="antibioticsDoctor" autocomplete="off" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="antibioticsTelephone">Tel&eacute;fono</label>
                  <input type="text" name="antibioticsTelephone" id="antibioticsTelephone" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="diseaseExtra">Tiene alguna enfermedad, condici&oacute;n o problema que no figure m&aacute;s arriba y que cree que yo deber&iacute;a saber? Explique por favor</label>
                  <input type="text" name="diseaseExtra" id="diseaseExtra" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="comments">Comentarios</label>
                  <input type="text" name="comments" id="comments" autocomplete="off" class="form-control">
                </div>
              </div>
            </div>
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
        <h5 class="modal-title" id="delLabel">Eliminar Alergia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="idDel" id="idDel">
        <p>¿Esta usted seguro que desea eliminar esta alergia?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" onClick="del($('#idDel').val())">Eliminar</button>
      </div>
    </div>
  </div>
</div>