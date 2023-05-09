const presciptions = '../Controllers/PrescriptionsController.php';

let saveMedicine = (msg) => {
    $.ajax({
        type  : 'post',
        url   : presciptions,
        data  : {
                    'ID' : $('#idMpp').val(),
                    'codPrescription' : $('#idPrescription').val(),
                    'codMedicine' : $('#medicine').val(),
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

                
                $('#addMedicine').modal('toggle');

                $('#medicines').DataTable().ajax.reload();
                $('#prescriptions').DataTable().ajax.reload();

        }
        });
};

let editPresciption = (id) => {
    $('#addMedicine').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : presciptions,
        data  : {
                  'ID': id,
                  'function' : 'em'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#idMpp').val(id);
            $('#indication').val(json[0]['indication']);
            $('#medicine').val(json[0]['cod_medicine']).trigger("change");

        }
      });
};

let loadIndication = (id) => {
    $.ajax({
        type  : 'post',
        url   : presciptions,
        data  : {
                  'ID': id,
                  'function' : 'li'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#indication').val(json[0]['indication']);

        }
      });
};

let delMedicine = (id) => {
    $.ajax({
        type  : 'post',
        url   : presciptions,
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

                  
                  $('#delMedicine').modal('toggle');

                  $('#prescriptions').DataTable().ajax.reload();
                  $('#medicines').DataTable().ajax.reload();
            }

        }
      });
}

let delPrescription = (id) => {
    $.ajax({
        type  : 'post',
        url   : presciptions,
        data  : {
                  'ID': id,
                  'function' : 'dp'
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

                  
                  $('#delPrescription').modal('toggle');

                  $('#prescriptions').DataTable().ajax.reload();
            }

        }
      });
}

let createNewPrescription = () => {
    $.ajax({
        type  : 'post',
        url   : presciptions,
        data  : {
                  'ID': $('#idAppointment').val(),
                  'function' : 'sp'
                },
        success: function (res) {
            if (typeof parseInt(res) == 'number'){
                $('#idPrescription').val(parseInt(res));
                createMedicinesDT($('#idPrescription').val());
                $('#medicinesContainer').fadeIn();
                $('#prescriptions').DataTable().ajax.reload();
            }
        }
      });
}

let showDelPresciption = (id) => {
    $('#idDelPrescription').val(id);
    $('#delPrescription').modal('toggle');
}

let showDelMedicine = (id) => {
    $('#idDelMedicine').val(id);
    $('#delMedicine').modal('toggle');
}

let createMedicinesDT = (id) => {
    $('#medicines').DataTable({
        "ajax" : presciptions+'?m='+id,
        "columns" : [
            {"data" : "id_mpp"},
            {"data" : "medicine"},
            {"data" : "indication"},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editPresciption('+data['cod_mpp']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelMedicine('+data['cod_mpp']+')"><i class="fas fa-trash-alt"></i></button></div>';
            }}
        ],
        autoWidth: false,
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Agregar medicamento',
                action: function (e, dt, node, config) {
                    $('#addMedicine').modal('toggle');
                }
            }
        ]
    });
}

let medicines = (id) =>{
    $('#idPrescription').val(id);
    if($('#idPrescription').val() != '' && $('#idPrescription').val() != null){
        $('#medicinesContainer').fadeIn();
        $('#createPr').prop('disabled', true);
        if ( ! $.fn.DataTable.isDataTable( '#medicines' ) ) {
            createMedicinesDT(id);
        }else{
            $('#addMedicines').modal('toggle');
            $('#medicines').DataTable().destroy();
            medicines(id);
        }
    }else{
        $('#medicinesContainer').fadeOut(0);
    }
    $('#addMedicines').modal('toggle');
    
}

let resetMedicineForm = () => {
    $('#addMedicineForm').trigger("reset");
    $('#idMpp').val('');
    $('#medicine').val(1).trigger("change");
}

let mpp = (id) => {
    $('#idAppointment').val(id);
    $('#addPr').modal('toggle');
    if ( ! $.fn.DataTable.isDataTable( '#prescriptions' ) ) {
        $('#prescriptions').DataTable({
            "ajax" : presciptions+'?p='+id,
            "columns" : [
                {"data" : "cod_prescription"},
                {"data" : "amount"},
                {"data" : null, render : function (data, type, row, meta) {
                    return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="medicines('+data['cod_prescription']+')"><i class="fa fa-edit"></i></button>'+
                    '<a class="btn btn-xs btn-default" target="_blank" href="http://localhost/clinic/pages/prescription.php?id='+data['cod_prescription']+'&p='+data['cod_patient']+'"><i class="fas fa-print"></i></a>'+
                    '<button class="btn btn-xs btn-danger" onClick="showDelPresciption('+data['cod_prescription']+')"><i class="fas fa-trash-alt"></i></button></div>';
                }}
            ],
            autoWidth: false,
            dom: 'Bfrtip',
            "buttons" : [
                {
                    text: 'Agregar receta',
                    action: function (e, dt, node, config) {
                        medicines(null);
                    }
                }
            ]
        });
    }else{
        $('#addPr').modal('toggle');
        $('#prescriptions').DataTable().destroy();
        mpp(id);
    }
}

$(document).ready(function() {
$('#addMedicineForm').validate({
    onfocusout: false,
    rules: {
        medicine: {
            required: true
        },
        indication: {
            required: true,
            minlength: 1
        }
    },
    messages: {
        medicine: "Por favor seleccione un medicamento",
        indication: "Por favor, ingrese una indicaci&oacute;n v&aacute;lida"
    },
    submitHandler: function(form) {
        saveMedicine();
        resetMedicineForm();
      }
});

    $('#medicine').select2()
    .on('change', () => {
        loadIndication($('#medicine').val());
    });
});