const uploadProcess = '../Controllers/UploadController.php';
const filesProcess = '../Controllers/FilesController.php';
var uploadTable = null;

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
                $('#uploadFiles').DataTable().ajax.reload();
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
});