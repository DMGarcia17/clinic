const invoices = '../Controllers/PaymentsController.php';

let savePayment = () => {
    $.ajax({
        type  : 'post',
        url   : invoices,
        data  : {
                    'ID' : $('#idPayment').val(),
                    'codInvoice' : $('#idInvoice').val(),
                    'amount' : $('#amountPayment').val(),
                    'function' : 'sp'
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

                refreshDebit($('#idInvoice').val(), $('#totalAmount').val());
                $('#editPayment').modal('toggle');

                $('#payDataTable').DataTable().ajax.reload();
                $('#paymentsTable').DataTable().ajax.reload();

        }
        });
};

let saveInvoice = () => {
    $.ajax({
        type  : 'post',
        url   : invoices,
        data  : {
                    'ID' : $('#idInvoiceField').val(),
                    'codAppointment' : $('#idAppointment').val(),
                    'treatment' : $('#treatmentDesc').val(),
                    'amount' : $('#amountInvoice').val(),
                    'idAppointment' : $('#idAppointment').val(),
                    'function' : 'si'
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

                $('#editInvoice').modal('toggle');

                $('#paymentsTable').DataTable().ajax.reload();

        }
        });
};

let editInvoice = (id) => {
    $('#addPayment').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : invoices,
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

let editPayment = (id, amount) => {
    $('#editPayment').modal('toggle');
    $('#amountPayment').val(amount);
    try{
        $('#amountPayment').rules('remove', 'max');
        $('#amountPayment').rules('add', {max: (parseFloat($('#debit').text().substring(1))+parseFloat(amount)), messages: {max: "El monto ingresado es mayor que la deuda, favor corregir!"}});
    }catch(err){
        console.error(err);
    }
    $('#idPayment').val(id);
};

let delPayment = (id) => {
    $.ajax({
        type  : 'post',
        url   : invoices,
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

                  
                  refreshDebit($('#idInvoice').val(), $('#totalAmount').val());
                $('#delPayment').modal('toggle');

                $('#payDataTable').DataTable().ajax.reload();
                $('#paymentsTable').DataTable().ajax.reload();
            }

        }
      });
}

let delInvoice = (id) => {
    console.log(id);
    $.ajax({
        type  : 'post',
        url   : invoices,
        data  : {
                  'ID': id,
                  'function' : 'di'
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

                  
                  refreshDebit($('#idInvoice').val(), $('#totalAmount').val());
                $('#delInvoice').modal('toggle');

                $('#paymentsTable').DataTable().ajax.reload();
            }

        }
      });
}

/*
let createNewPrescription = () => {
    $.ajax({
        type  : 'post',
        url   : invoices,
        data  : {
                  'ID': $('#idAppointment').val(),
                  'function' : 'sp'
                },
        success: function (res) {
            if (typeof parseInt(res) == 'number'){
                $('#idPrescription').val(parseInt(res));
                createPaymentsDT($('#idPrescription').val());
                $('#medicinesContainer').fadeIn();
                $('#paymentsTable').DataTable().ajax.reload();
            }
        }
      });
}*/

let showDelInvoice = (id) => {
    $('#idDelInvoice').val(id);
    $('#delInvoice').modal('toggle');
}

let showDelPayment = (id) => {
    $('#idDelPayment').val(id);
    $('#delPayment').modal('toggle');
}

let createPaymentsDT = (id) => {
    $('#payDataTable').DataTable({
        "ajax" : invoices+'?i='+id,
        "columns" : [
            {"data" : "paid_at"},
            {"data" : null, render : function (data, type, row, meta) {return (new Intl.NumberFormat('en-US', {style: 'currency', currency:'USD'}).format(data['amount']))}},
            {"data" : null, render : function (data, type, row, meta) {return (new Intl.NumberFormat('en-US', {style: 'currency', currency:'USD'}).format(data['total']))}},
            {"data" : null, render : function (data, type, row, meta) {
                return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="editPayment('+data['cod_payment']+','+data['amount']+')"><i class="fa fa-edit"></i></button>'+
                '<button class="btn btn-xs btn-danger" onClick="showDelPayment('+data['cod_payment']+')"><i class="fas fa-trash-alt"></i></button></div>';
            }}
        ],
        autoWidth: false,
        dom: 'Bfrtip',
        "buttons" : [
            {
                text: 'Agregar Abono',
                action: function (e, dt, node, config) {
                    $('#editPayment').modal('toggle');
                    resetPayDataForm();
                    $('#idInvoice').val($('#idInvoice').val());
                    $('#idPayment').val(null);
                }
            }
        ]
    });
}

let refreshDebit = (id, amount) => {
    $.ajax({
        type  : 'post',
        url   : invoices,
        data  : {
                  'ID': id,
                  'function' : 'rd'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#debit').text(new Intl.NumberFormat('en-US', {style: 'currency', currency:'USD'}).format((amount-json[0]['paid'])));

        }
      });
};

let payments = (id, amount) =>{
    $('#idInvoice').val(id);
    $('#totalAmount').val(amount);
    if(id != '' && id != null){
        refreshDebit(id, amount);
        if ( ! $.fn.DataTable.isDataTable( '#payDataTable' ) ) {
            createPaymentsDT(id);
        }else{
            $('#addPayments').modal('toggle');
            $('#payDataTable').DataTable().destroy();
            payments(id,amount);
        }
    }
    $('#payments').modal('toggle');
    
    setTimeout(() => {
        $('#payData').modal('toggle');
    }, 350);
    
}

let resetPaymentForm = () => {
    $('#addPaymentForm').trigger("reset");
    $('#idMpp').val('');
    $('#medicine').val(1).trigger("change");
}

let resetPayData = () => {
    $('#idInvoice').val('');
}

let resetPayDataForm = () => {
    $('#editPaymentForm').trigger("reset");
}

let resetInvoiceForm = () => {
    $('#editIForm').trigger("reset");
}

let showInvoicesModal = (id, patient) => {
    $('#idAppointment').val(id);
    $('#payments').modal('toggle');
    if ( ! $.fn.DataTable.isDataTable( '#paymentsTable' ) ) {
        $('#paymentsTable').DataTable({
            "ajax" : invoices+'?p='+id,
            "columns" : [
                {"data" : "cod_invoice"},
                {"data" : "treatment"},
                {"data" : null, render : function (data, type, row, meta) {return (new Intl.NumberFormat('en-US', {style: 'currency', currency:'USD'}).format(data['amount']))}},
                {"data" : null, render : function (data, type, row, meta) {return (new Intl.NumberFormat('en-US', {style: 'currency', currency:'USD'}).format(data['amount']-data['paid']))}},
                {"data" : null, render : function (data, type, row, meta) {
                    return '<div class="btn-group" role="group"><button class="btn btn-xs btn-success" onClick="payments('+data['cod_invoice']+','+data['amount']+')"><i class="fa fa-edit"></i></button>'+
                    '<a class="btn btn-xs btn-default" target="_blank" href="http://localhost/clinic/pages/invoiceResume.php?id='+data['cod_invoice']+'&p='+data['cod_patient']+'"><i class="fas fa-print"></i></a>'+
                    '<button class="btn btn-xs btn-danger" onClick="showDelInvoice('+data['cod_invoice']+')"><i class="fas fa-trash-alt"></i></button></div>';
                }}
            ],
            autoWidth: false,
            dom: 'Bfrtip',
            "buttons" : [
                {
                    text: 'Agregar Cargo',
                    action: function (e, dt, node, config) {
                        $('#editInvoice').modal('toggle');
                        $('#idInvoiceField').val('');
                    }
                }
            ]
        });
    }else{
        $('#payments').modal('toggle');
        $('#paymentsTable').DataTable().destroy();
        showInvoicesModal(id);
    }
}

$(document).ready(function() {
    
    $('#editPaymentForm').validate({
        onfocusout: false,
        rules: {
            amountPayment: {
                required: true,
                min: 0.01
            }
        },
        messages: {
            amountPayment: "Por favor seleccione un monto valido",
        },
        submitHandler: function(form) {
            savePayment();
            resetPaymentForm();
          }
    });
    $('#editIForm').validate({
        onfocusout: false,
        rules: {
            amountInvoice: {
                required: true,
                min: 0.01
            }
        },
        messages: {
            amountInvoice: "Por favor seleccione un monto valido",
        },
        submitHandler: function(form) {
            saveInvoice();
            resetInvoiceForm();
          }
    });

});