<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('invoices', 'treatment, cod_appointment, amount, created_at', "'{$_POST['treatment']}', '{$_POST['idAppointment']}', '{$_POST['amount']}', now()");
    }else{
        $res = $db->update('invoices', "treatment={$_POST['treatment']}", "amount='{$_POST['amount']}'");
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

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('invoices i', 'i.cod_invoice, i.treatment, i.amount, (select sum(p.amount) from payments p where p.cod_invoice = i.cod_invoice) paid');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sd':
        echo save($_POST['ID']);
        break;
    case 'ed':
        load($_POST['ID']);
        break;
    case 'dd':
        delete($_POST['ID']);
        break;
    default:
        query();
}