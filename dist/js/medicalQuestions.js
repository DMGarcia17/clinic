const process = '../Controllers/MedicalQuestionsController.php';
let save = (msg) => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'question' : $('#question').val(),
                    'pquestion' : $('#pquestion').val(),
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

                $('#medicalQuestions').DataTable().ajax.reload();

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
            $('#id').val(json[0]['cod_medical']);
            $('#question').val(json[0]['question']);
            $('#pquestion').val(json[0]['question_type']);

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

                  $('#medicalQuestions').DataTable().ajax.reload();
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
    $('#question').val(null);
    $('#pquestion').val('N').change();
}

$(document).ready(function() {
    $('#medicalQuestions').dataTable({
        "ajax" : process,
        "columns" : [
            {"data" : "cod_medical"},
            {"data" : "question"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="edit('+data['cod_medical']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelClinic('+data['cod_medical']+')"><i class="fas fa-trash-alt"></i></button></div>';
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
            question: {
                required: true,
                minlength: 1,
                maxlength: 500
            },
            pquestion: {
                required: true
            }
        },
        messages: {
            question: "Por favor ingrese una pregunta v&aacute;lida, con un ancho entre 1 y 500 caracteres.",
            pquestion: "Por favor seleccione una opci&oacute;n"
        },
        submitHandler: function(form) {
            save();
            resetForm();
          }
    });

    $('#medicalQuestionsTagMenu').addClass('active');

});