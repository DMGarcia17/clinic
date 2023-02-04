<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id != null) {
        $newId = $db->blankect_query('prescriptions', '(ifnull(max(cod_prescription),0)+1) id');
        $justCreated = 0;
        if(isset($newId[0]['id'])){
            $res = $db->insert('prescriptions', 'cod_prescription, cod_appointment', "'{$newId[0]['id']}', '{$id}'");
            $justCreated = $newId[0]['id'];
        }
    }
    return $justCreated;
}

function saveMedicine($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('mpp', 'cod_prescription, cod_medicine, amount, indication', "'{$_POST['codPrescription']}', '{$_POST['codMedicine']}', '{$_POST['amount']}', '{$_POST['indication']}'");
    }else{
        $res = $db->update('mpp', "cod_mpp={$_POST['ID']}", "cod_prescription='{$_POST['codPrescription']}', cod_medicine='{$_POST['codMedicine']}', amount='{$_POST['amount']}', indication='{$_POST['indication']}'");
    }
    return $res;
}

function loadMedicine($id){
    $db = new DatabaseConnection();
    $res = $db->filteredOquery('mpp', "cod_medicine, amount, indication, row_number() over (order by cod_mpp) id_mpp", 'cod_mpp='.$id, 'cod_mpp');
    echo json_encode($res);
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('appointment a', "(select concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name from patients p where p.cod_patient = a.cod_patient)name ,a.cod_appointment, a.cod_patient, a.reason, a.comments, a.diagnosis_resume, a.treatment, a.description, a.disability_days, a.visited_on", 'cod_appointment='.$id);
    echo json_encode($res);
}

function loadName($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('patients p', "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", 'cod_patient='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('prescriptions', 'cod_prescription='.$id);
    echo json_encode($res);
}

function deleteMedicine($id){
    $db = new DatabaseConnection();
    $res = $db->delete('mpp', 'cod_mpp='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('prescriptions p inner join appointment a on p.cod_appointment = a.cod_appointment', "a.cod_patient, p.cod_prescription, concat((select count(m.cod_mpp) from mpp m where m.cod_prescription=p.cod_prescription), ' Medicamentos Recetados') amount", "p.cod_appointment={$_GET['p']}");
    $formated = array('data' => $res);
    echo json_encode($formated);
}

function queryMedicines(){
    $db = new DatabaseConnection();
    $res = $db->filteredOquery('mpp m', "m.cod_mpp, (select a.description from medicines a where a.cod_medicine = m.cod_medicine) medicine, m.amount, m.indication, row_number() over (order by cod_mpp) id_mpp", "m.cod_prescription={$_GET['m']}", 'cod_mpp');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sp':
        echo save($_POST['ID']);
        break;
    case 'ep':
        load($_POST['ID']);
        break;
    case 'fp':
        loadName($_POST['ID']);
        break;
    case 'dp':
        delete($_POST['ID']);
        break;
    case 'sm':
        echo saveMedicine($_POST['ID']);
        break;
    case 'em':
        loadMedicine($_POST['ID']);
        break;
    case 'fm':
        loadName($_POST['ID']);
        break;
    case 'dm':
        deleteMedicine($_POST['ID']);
        break;
    default:
        if(isset($_GET['m'])){
            queryMedicines();
        }else{
            query();
        }
}