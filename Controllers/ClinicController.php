<?php
require_once '../core/Connection.php';
function saveClinic($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('clinics', 'clinic_name, address, phone_number, wssp_phone', "'{$_POST['clinicName']}', '{$_POST['address']}', '{$_POST['phone']}', '{$_POST['wssp']}'");
    }else{
        $res = $db->update('clinics', "cod_clinic={$_POST['ID']}", "clinic_name='{$_POST['clinicName']}', address='{$_POST['address']}', phone_number='{$_POST['phone']}', wssp_phone='{$_POST['wssp']}'");
    }
    return $res;
}

function loadClinic($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('clinics a', 'cod_clinic, clinic_name, address, phone_number, wssp_phone', 'cod_clinic='.$id);
    echo json_encode($res);
}

function delClinic($id){
    $db = new DatabaseConnection();
    $res = $db->delete('clinics', 'cod_clinic='.$id);
    echo json_encode($res);
}

function queryClinics(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('clinics a', 'a.cod_clinic, a.clinic_name, a.address, a.phone_number');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sc':
        echo saveClinic($_POST['ID']);
        break;
    case 'ec':
        loadClinic($_POST['ID']);
        break;
    case 'dc':
        delClinic($_POST['ID']);
        break;
    default:
        queryClinics();
}