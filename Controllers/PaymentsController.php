<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('invoices', ' treatment, cod_appointment, amount, created_at', "'{$_POST['treatment']}', '{$_POST['idAppointment']}', '{$_POST['amount']}', now()");
    }else{
        $res = $db->update('invoices', "treatment={$_POST['treatment']}", "amount='{$_POST['amount']}'");
    }
    return $res;
}

function savePayment($id){
    $db = new DatabaseConnection();
    echo "insert into payments(cod_invoice, amount, paid_at) values ('{$_POST['codInvoice']}', '{$_POST['amount']}', now())";
    if ($id == null) {
        $res = $db->insert('payments', 'cod_invoice, amount, paid_at', "'{$_POST['codInvoice']}', '{$_POST['amount']}', now()");
    }else{
        $res = $db->update('payments', "cod_payment={$id}", "amount='{$_POST['amount']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('invoices i', '*', 'cod_invoice='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('invoices', 'cod_invoice='.$id);
    echo json_encode($res);
}

function deletePayment($id){
    $db = new DatabaseConnection();
    $res = $db->delete('payments', 'cod_payment='.$id);
    echo json_encode($res);
}

function queryDebit($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('payments i', 'sum(i.amount) paid', "i.cod_invoice={$id}");
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('invoices i', 'i.cod_invoice, i.cod_appointment, i.treatment, i.amount, (select sum(p.amount) from payments p where p.cod_invoice = i.cod_invoice) paid, (select cod_patient from appointment a where a.cod_appointment = i.cod_appointment) cod_patient', "i.cod_appointment={$_GET['p']}");
    $formated = array('data' => $res);
    echo json_encode($formated);
}

function queryPayments(){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('payments i', 'i.paid_at,i.cod_payment, i.amount, (select a.amount from invoices a where a.cod_invoice = i.cod_invoice) total', "i.cod_invoice={$_GET['i']}");
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'si':
        echo save($_POST['ID']);
        break;
    case 'ed':
        load($_POST['ID']);
        break;
    case 'di':
        delete($_POST['ID']);
        break;
    case 'rd':
        queryDebit($_POST['ID']);
        break;
    case 'dp':
        deletePayment($_POST['ID']);
        break;
    case 'sp':
        echo savePayment($_POST['ID']);
        break;
    default:
        if (isset($_GET['i'])) {
            queryPayments();
        }else{
            query();
        }
}