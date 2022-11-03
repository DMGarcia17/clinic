const process = '../controllers/StatesProcess.php';
$(document).ready(function() {
    $('#stTagMenu').addClass('active');
    $('#stateDt').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "state", "width": "5%"},
            {"data" : "description", "width": "85%"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editSt(\''+data['state']+'\')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelSt(\''+data['state']+'\')"><i class="fas fa-trash-alt"></i></button></div>';
            }, "width": "10%" }
        ],
        autoWidth: false,
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Add',
                action: function (e, dt, node, config) {
                    resetForm();
                    $('#addState').modal('toggle');
                }
            }
        ]
    });
});


let saveSt = () => {
    if ($('#description').val() != undefined && $('#state').val() != undefined) {
        $.ajax({
            type  : 'post',
            url   : process,
            data  : {
                      'state' : $('#state').val(),
                      'description' : $('#description').val(),
                      'userAdd' : $('#userAdd').val(),
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

                  
                  $('#addState').modal('toggle');

                  $('#stateDt').DataTable().ajax.reload();

            }
          });
    }
};

let editSt = (id) => {
    $('#addState').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'state': id,
                  'function' : 'e'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#state').val(json[0]['state']);
            $('#description').val(json[0]['description']);
            $('#userAdd').val(json[0]['user_add']);
        }
      });
};

let deleteSt = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'state': id,
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

                  
                  $('#delSt').modal('toggle');

                  $('#stateDt').DataTable().ajax.reload();
            }

        }
      });
}

let showDelSt = (id) => {
    $('#idStDel').val(id);
    $('#delSt').modal('toggle');
}

let resetForm = ()=>{
    $('#state').val(null);
    $('#description').val(null);
    $('#userAdd').val(null);
}