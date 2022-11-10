const process = '../Controllers/DiseasesController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'name' : $('#name').val(),
                    'order' : $('#order').val(),
                    'description' : $('#description').val(),
                    'function' : 'sd'
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

                $('#diseases').DataTable().ajax.reload();

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
                  'function' : 'ed'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_disease']);
            $('#name').val(json[0]['name']);
            $('#order').val(json[0]['pr_order']);
            $('#description').val(json[0]['description']);

        }
      });
};

let del = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'dd'
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

                  $('#diseases').DataTable().ajax.reload();
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
    $('#diseases').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "pr_order"},
            {"data" : "name"},
            {"data" : "description"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_disease']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_disease']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
                number: true
            }
        },
        messages: {
            name: "Por favor ingrese un nombre de enfermedad valido, con un ancho entre 1 y 500 caracteres.",
            description: "Por favor ingrese una descripci&oacute;n valida, con un ancho entre 1 y 500 caracteres.",
            order: {
                required: "Este campo es requerido",
                number: "Por favor, ingrese un valor num&eacute;rico"
            }
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });
    $('#diseasesTagMenu').addClass('active');

});