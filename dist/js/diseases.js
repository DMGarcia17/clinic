const process = '../Controllers/DiseasesController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'name' : $('#name').val(),
                    'description' : $('#description').val(),
                    'oral' : $('#oral').val(),
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
            $('#description').val(json[0]['description']);
            $('#oral').val(json[0]['oral']).change();
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
    $('#addForm').trigger("reset");
    $('#id').val(null);
}

$(document).ready(function() {
    $('#diseases').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "cod_disease"},
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
            },
            {
                text: 'Carga Masiva de Registros',
                action: function (e, dt, node, config) {
                    $('#upload').modal('toggle');
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
            }
        },
        messages: {
            name: "Por favor ingrese un nombre de enfermedad valido, con un ancho entre 1 y 500 caracteres.",
            description: "Por favor ingrese una descripci&oacute;n valida, con un ancho entre 1 y 500 caracteres."
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });

    $("#uploadForm").on('submit',(function(e) {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000
          });
        e.preventDefault();
        $.ajax({
            url: process,
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function(){
                Toast.fire({
                    icon: 'info',
                    title: 'Subiendo...'
                  });
            },
            success: function(data, status, jqXHR){
                if(data=='invalid'){
                    
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid File'
                  });
                }else if(data=='error_file_exists'){
                    
                Toast.fire({
                    icon: 'error',
                    title: 'El archivo ya existe, por favor cambie el nombre del archivo antes de subirlo!'
                  });
                }else{
                    $("#uploadForm").trigger("reset");
                    Toast.fire({
                        icon: 'success',
                        title: 'Exitoso'
                      });
                }
                
                $('#diseases').DataTable().ajax.reload();
                $('#upload').modal('toggle');
            },
            error: function(e){
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                  });
                  console.error(e);
            }          
        });
    }));

    $('#diseasesTagMenu').addClass('active');

});