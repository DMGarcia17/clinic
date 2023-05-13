const process = '../Controllers/PatientsController.php';
let save = (msg) => {
    let data = {
        'ID' : $('#id').val(),
        'firstName' : $('#firstName').val(),
        'secondName' : $('#secondName').val(),
        'firstSurname' : $('#firstSurname').val(),
        'secondSurname' : $('#secondSurname').val(),
        'phoneNumber' : $('#phoneNumber').val(),
        'cellphoneNumber' : $('#cellphoneNumber').val(),
        'address' : $('#address').val(),
        'city' : $('#city').val(),
        'state' : $('#state').val(),
        'postalCode' : $('#postalCode').val(),
        'occupation' : $('#occupation').val(),
        'height' : $('#height').val(),
        'weight' : $('#weight').val(),
        'birthday' : $('#birthday').val(),
        'gender' : $('#gender').val(),
        'numIdPatient' : $('#numIdPatient').val(),
        'emergencyCall' : $('#emergencyCall').val(),
        'related' : $('#related').val(),
        'phoneEmergency' : $('#phoneEmergency').val(),
        'cellphoneEmergency' : $('#cellphoneEmergency').val(),
        'filledBy' : $('#filledBy').val(),
        'relatedFb' : $('#relatedFb').val(),
        'doctorsCare' : $('#doctorsCare').val(),
        'doctorsName' : $('#doctorsName').val(),
        'doctorsPhone' : $('#doctorsPhone').val(),
        'doctorsAddress' : $('#doctorsAddress').val(),
        'doctorsCity' : $('#doctorsCity').val(),
        'doctorsZip' : $('#doctorsZip').val(),
        'healthyPatient' : $('#healthyPatient').val(),
        'stableHealth' : $('#stableHealth').val(),
        'doctorsCondition' : $('#doctorsCondition').val(),
        'examsDate' : $('#examsDate').val(),
        'pastYears' : $('#pastYears').val(),
        'diseasePast' : $('#diseasePast').val(),
        'takenMedicine' : $('#takenMedicine').val(),
        'medicine' : $('#medicine').val(),
        'antibiotics' : $('#antibiotics').val(),
        'antibioticsDoctor' : $('#antibioticsDoctor').val(),
        'antibioticsTelephone' : $('#antibioticsTelephone').val(),
        'diseaseExtra' : $('#diseaseExtra').val(),
        'comments' : $('#comments').val(),
        'isAllergic' : $('#isAllergic').val(),
        'allergies' : $('#allergies').val(),
        'function' : 'sp'
    };

    let printed = $('#mq').val();
    
    if(printed != 'N/A'){
        $.each(printed.split(','), function(i, v){
            data[v]=$(('#'+v+'question')).val();
        });
    }
    data['printed']=$('#mq').val();


    $.ajax({
        type  : 'post',
        url   : process,
        data,
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

                
                $('#add').modal('toggle');

                $('#patients').DataTable().ajax.reload();

        }
        });
};

let loadMQ = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'lp'
                },
        success: function (res) {
            let json = JSON.parse(res);
            console.log(json);
            $.each(json, function(i, v){
                //console.log(v['cod_question']);
                $(('#'+v['cod_question']+'question')).val(v['answer']).change();
            });

        }
      });
};

let edit = (id) => {
    $('#add').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'ep'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_patient']);
            $('#firstName').val(json[0]['first_name']);
            $('#secondName').val(json[0]['second_name']);
            $('#firstSurname').val(json[0]['first_surname']);
            $('#secondSurname').val(json[0]['second_surname']);
            $('#phoneNumber').val(json[0]['phone_number']);
            $('#cellphoneNumber').val(json[0]['cellphone_number']);
            $('#address').val(json[0]['address']);
            $('#city').val(json[0]['city']);
            $('#state').val(json[0]['state']);
            $('#postalCode').val(json[0]['postal_code']);
            $('#occupation').val(json[0]['occupation']);
            $('#height').val(json[0]['height']);
            $('#weight').val(json[0]['weight']);
            $('#birthday').val(json[0]['birthday']);
            $('#gender').val(json[0]['gender']).change();
            $('#numIdPatient').val(json[0]['num_id_patient']);
            $('#emergencyCall').val(json[0]['emergency_call']);
            $('#related').val(json[0]['related']);
            $('#phoneEmergency').val(json[0]['phone_emergency']);
            $('#cellphoneEmergency').val(json[0]['cellphone_emergency']);
            $('#filledBy').val(json[0]['filled_by']);
            $('#relatedFb').val(json[0]['related_fb']);
            $('#doctorsCare').val(json[0]['doctors_care']).change();
            $('#doctorsName').val(json[0]['doctors_name']);
            $('#doctorsPhone').val(json[0]['doctors_phone']);
            $('#doctorsAddress').val(json[0]['doctors_address']);
            $('#doctorsCity').val(json[0]['doctors_city']);
            $('#doctorsState').val(json[0]['doctors_state']);
            $('#doctorsZip').val(json[0]['doctors_zip']);
            $('#healthyPatients').val(json[0]['healthy_patients']);
            $('#stableHealth').val(json[0]['stable_health']);
            $('#doctorsCondition').val(json[0]['doctors_condition']);
            $('#examsDate').val(json[0]['exams_date']);
            $('#pastYears').val(json[0]['past_years']);
            $('#diseasePast').val(json[0]['disease_past']);
            $('#takenMedicine').val(json[0]['taken_medicine']);
            $('#medicine').val(json[0]['medicine']);
            $('#antibiotics').val(json[0]['antibiotics']);
            $('#antibioticsDoctor').val(json[0]['antibioticsDoctor']);
            $('#antibioticsTelephone').val(json[0]['antibioticsTelephone']);
            $('#diseaseExtra').val(json[0]['diseaseExtra']);
            $('#comments').val(json[0]['comments']);
            $('#allergies').val(json[0]['allergies']);
            $('#isAllergic').val(json[0]['is_allergic']);


            loadMQ(json[0]['cod_patient']);

        }
      });
};

let del = (id) => {
    $('#del').modal('toggle');
    showDelConf(id);
}

let delConf = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'dp'
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

                  
                  $('#delConf').modal('toggle');

                  $('#patients').DataTable().ajax.reload();
            }

        }
      });
}

let showDelPatient = (id) => {
    $('#idDel').val(id);
    $('#del').modal('toggle');
}

let showDelConf = (id) => {
    $('#idDelConf').val(id);
    $('#delConf').modal('toggle');
}

let resetForm = ()=>{
    /*$('#id').val(null);
    $('#name').val(null);
    $('#order').val(null);
    $('#description').val(null);*/
    $('#addForm').trigger("reset");
}

$(document).ready(function() {
    $('#patients').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "cod_patient"},
            {"data" : "name"},
            {"data" : "last_reason"},
            {"data" : "last_visit"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_patient']+')"><i class="fa fa-edit"></i></button><div class="btn-group" role="group"><button class="btn btn-xs btn-warning" onClick="window.location.href=\'http://localhost/clinic/pages/appointments.php?ID='+data['cod_patient']+'\'"><i class="fa fa-tooth"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelPatient('+data['cod_patient']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
            name: {
                required: true,
                minlength: 1,
                maxlength: 500
            },
            description: {
                required: true,
                minlength: 1,
                maxlength: 500
            },
            order: {
                required: true,
                number: true,
                min: 1
            }
        },
        messages: {
            name: "Por favor ingrese un nombre de alergia v&aacute;lido, con un ancho entre 1 y 500 caracteres.",
            description: "Por favor ingrese una descripci&oacute;n valida, con un ancho entre 1 y 500 caracteres.",
            order: {
                required: "Este campo es requerido",
                number: "Por favor, ingrese un valor num&eacute;rico",
                min: "Por favor ingrese un n&uacute;mero mayor o acaso igual a 1"
            }
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });
    $('#patientTag').addClass('active');

});