const process = '../Controllers/medicineController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'medicine' : $('#medicine').val(),
                    'chemicalCompound' : $('#chemicalCompound').val(),
                    'indication' : $('#indication').val(),
                    'function' : 'sm'
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

                $('#medicines').DataTable().ajax.reload();

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
                  'function' : 'em'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_medicine']);
            $('#medicine').val(json[0]['description']);
            $('#indication').val(json[0]['indication']);
            $('#chemicalCompound').val(json[0]['chemical_compound']);

        }
      });
};

let del = (id) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                  'ID': id,
                  'function' : 'dm'
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

                  $('#medicines').DataTable().ajax.reload();
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
}

$(document).ready(function() {
    $('#medicines').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "id_medicine"},
            {"data" : "description"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_medicine']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_medicine']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
            medicine: {
                required: true,
                minlength: 1,
                maxlength: 500
            }
        },
        messages: {
            medicine: "Por favor ingrese un nombre de medicamento v&aacute;lido, con un ancho entre 1 y 500 caracteres."
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });

    $('#medicinesTagMenu').addClass('active');

});