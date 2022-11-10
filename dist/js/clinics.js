const process = '../Controllers/ClinicController.php';
let saveClinic = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#clinicId').val(),
                    'clinicName' : $('#clinicName').val(),
                    'address' : $('#clinicAddress').val(),
                    'phone' : $('#clinicPhone').val(),
                    'function' : 'sc'
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

                
                $('#add').modal('toggle');

                $('#clinics').DataTable().ajax.reload();

        }
        });
};

let editClinic = (id) => {
    $('#add').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'ec'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#clinicId').val(json[0]['cod_clinic']);
            $('#clinicName').val(json[0]['clinic_name']);
            $('#clinicAddress').val(json[0]['address']);
            $('#clinicPhone').val(json[0]['phone_number']);

        }
      });
};

let deleteClinic = (id) => {
    console.log('Clinic ID: '+id);
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'dc'
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

                  $('#clinics').DataTable().ajax.reload();
            }

        }
      });
}

let showDelClinic = (id) => {
    $('#idClinicDel').val(id);
    $('#del').modal('toggle');
}

let resetForm = ()=>{
    $('#clinicId').val(null);
    $('#clinicAddress').val(null);
    $('#clinicName').val(null);
    $('#clinicPhone').val(null);
}

$(document).ready(function() {
    $('#clinics').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "cod_clinic"},
            {"data" : "clinic_name"},
            {"data" : "phone_number"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editClinic('+data['cod_clinic']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_clinic']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
            clinicName: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            clinicAddress: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            clinicPhone: {
                required: true,
                phoneSV: true
            }
        },
        messages: {
            clinicName: "Por favor ingrese un nombre valido, con un ancho entre 10 y 500 caracteres.",
            clinicAddress: "Por favor ingrese una dirección valida, con un ancho entre 10 y 500 caracteres.",
            clinicPhone: {
                required: "Este campo es requerido"
            }
        },
        submitHandler: function(form) {
            saveClinic();
            resetForm();
          }
    });
    $('#clinicsTagMenu').addClass('active');

});