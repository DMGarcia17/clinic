const process = '../Controllers/UsersController.php';
let save = (msg) => {
    let Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
        });
    if(!$('#id').val() && !$('#password').val()) {
        Toast.fire({
            icon: 'error',
            title: 'Por favor ingrese un contraseña para el nuevo usuario!'
            });
        return;
    }

    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'id' : $('#id').val(),
                    'username' : $('#username').val(),
                    'completeName' : $('#completeName').val(),
                    'password' : $('#password').val(),
                    'defaultClinic' : $('#defaultClinic').val(),
                    'function' : 'su'
                },
        success: function (res) {

                Toast.fire({
                icon: 'success',
                title: 'Datos guardados!'
                });

                
                $('#add').modal('toggle');
                resetForm();
                $('#users').DataTable().ajax.reload();

        }
        });
};

let edit = (id) => {
    $('#add').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'id': id,
                  'function' : 'eu'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id, #username').val(json[0]['username']);
            $('#completeName').val(json[0]['complete_name']);
            $('#defaultClinic').val(json[0]['default_clinic']).change();

        }
      });
};

let delUser = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'id': id,
                  'function' : 'du'
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

                  $('#users').DataTable().ajax.reload();
            }

        }
      });
}

let showDelUser = (id) => {
    $('#idUserDel').val(id);
    $('#del').modal('toggle');
}

let resetForm = ()=>{
    $('#id').val(null);
    $('#addForm').trigger("reset");
}

$(document).ready(function() {
    $('#users').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "id"},
            {"data" : "username"},
            {"data" : "complete_name"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit(\''+data['username']+'\')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelUser(\''+data['username']+'\')"><i class="fas fa-trash-alt"></i></button></div>';
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
            completeName: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            username: {
                required: true,
                minlength: 3,
                maxlength: 20
            },
            password: {
                minlength: 6,
                maxlength: 20
            },
            defaultClinic: {
                required: true
            }
        },
        messages: {
            completeName: "Por favor ingrese un nombre valido, con un ancho entre 10 y 500 caracteres.",
            username: "Por favor ingrese un nombre de usuario valido, con un ancho entre 10 y 20 caracteres.",
            password: "Por favor ingrese una contraseña con un ancho entre 6 y 20 caracteres."
        },
        submitHandler: function(form) {
            save();
          }
    });
    $('#usersTagMenu').addClass('active');

});