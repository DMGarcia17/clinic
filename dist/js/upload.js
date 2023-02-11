const uploadProcess = '../Controllers/UploadController.php';
const filesProcess = '../Controllers/FilesController.php';
var uploadTable = null;
/*let save = (msg) => {
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

                $('#allergies').DataTable().ajax.reload();

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
                  'function' : 'ea'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_allergie']);
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

                  $('#allergies').DataTable().ajax.reload();
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
    $('#allergies').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "pr_order"},
            {"data" : "name"},
            {"data" : "description"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_allergie']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_allergie']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
    $('#allergiesTagMenu').addClass('active');

});*/

let delUpload = (id, name) => {
    $.ajax({
        type  : 'post',
        url   : filesProcess,
        data  : {
                  'ID': id,
                  'name': name,
                  'function' : 'df'
                },
        success: function (res) {
            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (res == 'true'){

                  Toast.fire({
                    icon: 'success',
                    title: 'Eliminaci&oacute;n Exitosa!'
                  });

                  
                  $('#delUpload').modal('toggle');

                  $('#uploadFiles').DataTable().ajax.reload();
            }else{
                Toast.fire({
                    icon: 'error',
                    title: 'Error al eliminar'
                  });
                  $('#delUpload').modal('toggle');
            }

        }
      });
}

let showDelFile = (id, name) => {
    $('#idDelUpload').val(id);
    $('#nameDelUpload').val(name);
    $('#delUpload').modal('toggle');
}

let createFilesDT = (id) => {
    $('#uploadFiles').DataTable({
        "ajax" : filesProcess+'?a='+id,
        "columns" : [
            {"data" : "id_file", width: 30},
            {"data" : "name", width: 800},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><a class="btn btn-xs btn-primary" target="_blank" href="http://localhost/clinic/files/'+data['name']+'"><i class="fa fa-external-link-alt"></i></a>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelFile('+data['cod_file']+', \''+data['name']+'\')"><i class="fas fa-trash-alt"></i></button></div>';
            }}
        ],
        autoWidth: false
    });
}

var showUploadModal = (id, patient) => {
    $('#upload').modal('toggle');
    let appointment = (id != null) ? id : '0';
    
    $('#idApp').val(appointment);
    
    $('#idPatient').val(patient);
    // TODO: Add DataTable settings and destroying process    
    if ( ! $.fn.DataTable.isDataTable( '#uploadFiles' ) ) {
        createFilesDT(appointment);
    }else{
        $('#upload').modal('toggle');
        $('#uploadFiles').DataTable().destroy();
        showUploadModal(appointment);
    }
}

$(document).ready(function (e) {
    $("#uploadForm").on('submit',(function(e) {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1000
          });
        e.preventDefault();
        $.ajax({
            url: "../Controllers/UploadController.php",
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
                    // invalid file format.
                    //$("#err").html("Invalid File !").fadeIn();
                    
                Toast.fire({
                    icon: 'warning',
                    title: 'Invalid File'
                  });
                }else if(data=='error_file_exists'){
                    // invalid file format.
                    //$("#err").html("Invalid File !").fadeIn();
                    
                Toast.fire({
                    icon: 'error',
                    title: 'El archivo ya existe, por favor cambie el nombre del archivo antes de subirlo!'
                  });
                }else{
                    // view uploaded file.
                    /*$("#preview").html(data).fadeIn();*/ 
                    $("#uploadForm").trigger("reset");
                    Toast.fire({
                        icon: 'success',
                        title: 'Exitoso'
                      });
                }
                $('#uploadFiles').DataTable().ajax.reload();
            },
            error: function(e){
                //$("#err").html(e).fadeIn();
                
                Toast.fire({
                    icon: 'error',
                    title: 'Error'
                  });
                  console.error(e);
            }          
        });
    }));
});