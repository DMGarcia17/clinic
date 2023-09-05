const process = '../Controllers/AppointmentsController.php';
var showed = 0;
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'reason' : $('#reason').val(),
                    'comments' : $('#comments').val(),
                    'patient' : $('#patient').val(),
                    'diagnosisResume' : $('#diagnosisResume').val(),
                    'systemicDiagnosis' : $('#systemicDiagnosis').val(),
                    'description' : $('#description').val(),
                    'disabilityDays' : $('#disabilityDays').val(),
                    'visitedOn' : $('#visitedOn').val(),
                    'nextAppointment' : $('#nextAppointment').val(),
                    'treatment' : $('#treatmentField').val().join(','),
                    'function' : 'sa'
                },
        success: function (res) {
            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });

                Toast.fire({
                icon: 'success',
                title: 'Datos guardados!'
                });

                $('#appIdCurr').val(res.split('|')[0]);
                
                $('#add').modal('toggle');

                $('#appointments').DataTable().ajax.reload();

        }
        });
        
};

let loadSystemicDiag = (idPatient) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': idPatient,
                  'function' : 'lsp'
                },
        success: function (res) {
            let json = JSON.parse(res);
            try{
                $('#systemicDiagnosis').val(json[0]['systemic_diagnosis']);
            } catch(err){
                console.log(err);
            }

        }
      });
};

let edit = (id, show = 0) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'ea'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_appointment']);
            $('#reason').val(json[0]['reason']);
            $('#name').val(json[0]['name']);
            $('#patient').val(json[0]['cod_patient']);
            $('#comments').val(json[0]['comments']);
            $('#prescribed').val(json[0]['medicines']);
            try{
                $('#systemicDiagnosis').val(json[0]['systemic_diagnosis']);
            } catch(err){
                console.log(err);
            }
            try{
                $("#treatmentField").val(json[0]['treatment'].split(",")).trigger("change");
            } catch(err){
                console.log(err);
            }
            try{
                $("#diagnosisResume").val(json[0]['diagnosis_resume'].split(","));
            } catch(err){
                console.log(err);
            }
            $('#description').val(json[0]['description']);
            $('#nextAppointment').val(json[0]['next_appointment']);
            $('#disabilityDays').val(json[0]['disability_days']);
            $('#visitedOn').val(json[0]['visited_on']);
            console.log(show);
            if(show != 1){
                $('#add').modal('show');
            }
        }
      });
};

let reLocate = () => {
    if(typeof $('#patient').val() == 'number' && $('#patient').val() > 0){
        save();
        window.location.href = "http://localhost/clinic/pages/appointments.php?app="+$('#appIdCurr').val();
    }
};

let findName = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'fa'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#name').val(json[0]['name']);
        }
      });
      
      loadSystemicDiag($('#patientId').val());
}

let del = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'da'
                },
        success: function (res) {
            if (res == 'true'){
                let Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

                  Toast.fire({
                    icon: 'success',
                    title: 'Eliminaci&oacute;n Exitosa!'
                  });

                  
                  $('#del').modal('toggle');

                  $('#appointments').DataTable().ajax.reload();
            }

        }
      });
}

let showPrintsModal = (appointment, patient, disabilityDays) => {
    $('#prints').modal('toggle');
    $('#idMDAppointment').val(appointment);
    $('#idMDPatient').val(patient);
    $('#daysOff').val(disabilityDays);
}

let showIncapabilityModal = (appointment, patient) => {
    $('#prints').modal('toggle');
    $('#inability').modal('toggle');
    $('#inabilityForm').attr('action', 'http://localhost/clinic/pages/inabilityConstance.php?id='+appointment+'&p='+patient);
    $('#inabilityDays').val($('#daysOff').val());
}

let showAuth1Modal = (appointment, patient) => {
    $('#prints').modal('toggle');
    $('#auth1').modal('toggle');
    $('#auth1Form').attr('action', 'http://localhost/clinic/pages/authorization.php?id='+appointment+'&p='+patient);
}

let showAuth2Modal = (appointment, patient) => {
    $('#prints').hide(300);
    $('#auth2').modal('toggle');
    $('#auth2Form').attr('action', 'http://localhost/clinic/pages/consent.php?id='+appointment+'&p='+patient);
}

let showDelClinic = (id) => {
    $('#idDel').val(id);
    $('#del').modal('toggle');
}

let resetForm = ()=>{
    $('#addForm').trigger("reset");
    $('#systemicDiagnosis').val('').trigger('change');
    $('#treatmentField').val('').trigger('change');
}

$(document).ready(function() {

    if($('#patientId').val() != '' && $('#patientId').val() != undefined){
        findName($('#patientId').val());
        $('#add').modal('toggle');
        $('#patient').val($('#patientId').val());
    }else if($('#appIdCurr').val() != '' && $('#appIdCurr').val() != undefined){
        edit($('#appIdCurr').val(),1);
        showed=1;
        showUploadModal($('#appIdCurr').val(), $('#patient').val());
    }

    $('#appointments').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "cod_appointment"},
            {"data" : "name"},
            {"data" : "visited_on"},
            {"data" : "reason"},
            {"data" : "diagnosis_resume"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_appointment']+')"><i class="fa fa-edit"></i></button>'+
                '<a class="btn btn-xs btn-default" target="_blank" href="http://localhost/clinic/pages/odontograma.php?id='+data['cod_patient']+'"><i class="fas fa-tooth"></i></a>'+
                '<button class="btn btn-xs btn-default" onClick="mpp('+data['cod_appointment']+')"><i class="fas fa-prescription-bottle-medical"></i></button>'+
                '<button class="btn btn-xs btn-default" onClick="showPrintsModal('+data['cod_appointment']+', '+data['cod_patient']+', '+data['disability_days']+')"><i class="fas fa-print"></i></button>'+
                '<button class="btn btn-xs btn-default" onClick="showUploadModal('+data['cod_appointment']+', '+data['cod_patient']+')"><i class="fas fa-archive"></i></button>'+
                '<button class="btn btn-xs btn-default" onClick="showInvoicesModal('+data['cod_appointment']+', '+data['cod_patient']+')"><i class="fas fa-dollar"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_appointment']+')"><i class="fas fa-trash-alt"></i></button></div>';
            } }
        ],
        autoWidth: false,
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Agregar',
                action: function (e, dt, node, config) {
                    $('#add').modal('toggle');
                }
            }
        ]
    });


    $('#addForm').validate({
        onfocusout: false,
        rules: {    
            patient: {
                required: true
            },
            name: {
                required: true,
                minlength: 1,
                maxlength: 500
            }
        },
        messages: {
            name: "Por favor ingrese un nombre de alergia v&aacute;lido, con un ancho entre 1 y 500 caracteres."
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });

    $('#appointmentTag').addClass('active');
    $('#treatmentField').select2();

});