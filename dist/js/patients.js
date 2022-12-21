const process = '../Controllers/PatientsController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'name' : $('#name').val(),
                    'order' : $('#order').val(),
                    'description' : $('#description').val(),
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

                
                $('#add').modal('toggle');

                $('#patients').DataTable().ajax.reload();

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
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);
            $('#').val(json[0]['']);

        }
      });
};

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

                  $('#patients').DataTable().ajax.reload();
            }

        }
      });
}

let showDelClinic = (id) => {
    $('#idDel').val(id);
    $('#del').modal('toggle');
}

let resetForm = ()=>{
    $('#id').val(null);
    $('#name').val(null);
    $('#order').val(null);
    $('#description').val(null);
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
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_patient']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_patient']+')"><i class="fas fa-trash-alt"></i></button></div>';
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