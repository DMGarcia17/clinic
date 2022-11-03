const process = '../controllers/DailyLogProcess.php';
$(document).ready(function() {
    $('#dsTagMenu').addClass('active');
    $('#dailyLog').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "ID", "width": "5%"},
            {"data" : "file", "width": "5%"},
            {"data" : "registration_date", "width": "15%"},
            {"data" : "details", "width": "50%"},
            {"data" : "state", "width": "15%"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editDl('+data['ID']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelDl('+data['ID']+')"><i class="fas fa-trash-alt"></i></button></div>';
            }, "width": "10%" }
        ],
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Add',
                action: function (e, dt, node, config) {
                    resetForm();
                    $('#addSummary').modal('toggle');
                }
            }
        ]
    });
});


let saveDl = () => {
    if ($('#registrationDate').val() != undefined && $('#fileName').val() != undefined) {
        $.ajax({
            type  : 'post',
            url   : process,
            data  : {
                      'ID': $('#summaryId').val(),
                      'file' : $('#fileName').val(),
                      'registrationDate' : $('#registrationDate').val(),
                      'details' : $('#details').val(),
                      'state' : $('#state').val(),
                      'function' : 's'
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

                  
                  $('#addSummary').modal('toggle');

                  $('#dailyLog').DataTable().ajax.reload();

            }
          });
    }
};

let editDl = (id) => {
    $('#addSummary').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'e'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#summaryId').val(json[0]['ID']);
            $('#registrationDate').val(json[0]['registration_date']);
            $('#details').val(json[0]['details']);
            $('#fileName').val(json[0]['file']).change();
            $('#state').val(json[0]['state']).change();

        }
      });
};

let deleteDl = (id) => {
    console.log('File ID: '+id);
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'd'
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
                    title: 'Record deleted successful!'
                  });

                  
                  $('#delDl').modal('toggle');

                  $('#dailyLog').DataTable().ajax.reload();
            }

        }
      });
}

let showDelDl = (id) => {
    $('#idDlDel').val(id);
    $('#delDl').modal('toggle');
}

let resetForm = ()=>{
    $('#summaryId').val(null);
    $('#details').val(null);
    $('#registrationDate').val(null);
}