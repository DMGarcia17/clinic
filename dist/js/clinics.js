$(document).ready(function() {
    $('#filesTagMenu').addClass('active');
    $('#files').dataTable({
        "ajax" : "../controllers/fileProcess.php",
        "columns" : [
            {"data" : "ID"},
            {"data" : "name"},
            {"data" : "extension"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editFile('+data['ID']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelFile('+data['ID']+')"><i class="fas fa-trash-alt"></i></button></div>';
            } }
        ],
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Add',
                action: function (e, dt, node, config) {
                    $('#addFile').modal('toggle');
                }
            }
        ]
    });
});


let saveFile = () => {
    if ($('#fileName').val() != undefined && $('#fileExtension').val() != undefined) {
        $.ajax({
            type  : 'post',
            url   : '../controllers/fileProcess.php',
            data  : {
                      'ID': $('#fileId').val(),
                      'name' : $('#fileName').val(),
                      'extension' : $('#fileExtension').val(),
                      'function' : 'sf'
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
                    title: 'Data saved successful!'
                  });

                  
                  $('#addFile').modal('toggle');

                  $('#files').DataTable().ajax.reload();

            }
          });
    }
};

let editFile = (id) => {
    $('#addFile').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : '../controllers/fileProcess.php',
        data  : {
                  'ID': id,
                  'function' : 'ef'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#fileId').val(json[0]['ID']);
            $('#fileName').val(json[0]['name']);
            $('#fileExtension').val(json[0]['extension']).change();

        }
      });
};

let deleteFile = (id) => {
    console.log('File ID: '+id);
    $.ajax({
        type  : 'post',
        url   : '../controllers/fileProcess.php',
        data  : {
                  'ID': id,
                  'function' : 'df'
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
                    title: 'File deleted successful!'
                  });

                  
                  $('#delFile').modal('toggle');

                  $('#files').DataTable().ajax.reload();
            }

        }
      });
}

let showDelFile = (id) => {
    $('#idFileDel').val(id);
    $('#delFile').modal('toggle');
}

let resetForm = ()=>{
    $('#fileId').val(null);
    $('#fileName').val(null);
}