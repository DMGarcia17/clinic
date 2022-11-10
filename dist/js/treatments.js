const process = '../Controllers/TreatmentsController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'name' : $('#name').val(),
                    'order' : $('#order').val(),
                    'showRP' : $('#showRP').val(),
                    'ptreatment' : $('#ptreatment').val(),
                    'description' : $('#description').val(),
                    'function' : 'st'
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

                $('#treatments').DataTable().ajax.reload();

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
                  'function' : 'et'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_treatment']);
            $('#name').val(json[0]['name']);
            $('#order').val(json[0]['pr_order']);
            $('#ptreatment').val(json[0]['ptr']);
            $('#showRP').val(json[0]['show_rp']).change();
            $('#description').val(json[0]['description']).change();

        }
      });
};

let del = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'dt'
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

                  $('#treatments').DataTable().ajax.reload();
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
    $('#ptreatment').val('N').change();
    $('#showRP').val('N').change();
}

$(document).ready(function() {
    $('#treatments').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "pr_order"},
            {"data" : "name"},
            {"data" : "description"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_treatment']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_treatment']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
            },
            showRP: {
                required: true
            },
            ptreatment: {
                required: true
            }
        },
        messages: {
            name: "Por favor ingrese un nombre de alergia v&aacute;lido, con un ancho entre 1 y 500 caracteres.",
            description: "Por favor ingrese una descripci&oacute;n valida, con un ancho entre 1 y 500 caracteres.",
            order: {
                required: "Este campo es requerido",
                number: "Por favor, ingrese un valor num&eacute;rico",
                min: "Por favor ingrese un n&uacute;mero mayor o acaso igual a 1"
            },
            showRP: "Por favor seleccione una opci&oacute;n",
            ptreatment: "Por favor seleccione una opci&oacute;n"
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });

    $('#treatmentsTagMenu').addClass('active');

});