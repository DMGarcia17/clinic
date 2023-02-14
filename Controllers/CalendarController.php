<?php
require_once '../core/Connection.php';
session_start();
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('events', 'name, start_at, end_at, clinic, event_type', "'{$_POST['name']}', STR_TO_DATE('{$_POST['start']}', '%Y-%m-%dT%T:%i'), STR_TO_DATE('{$_POST['end']}', '%Y-%m-%dT%T:%i'), {$_SESSION['codClinic']}, '{$_POST['eventType']}'");
    }else{
        $res = $db->update('events', "cod_event={$_POST['ID']}", "name='{$_POST['name']}', start_at=STR_TO_DATE('{$_POST['start']}', '%Y-%m-%dT%T:%i'), end_at=STR_TO_DATE('{$_POST['end']}', '%Y-%m-%dT%T:%i')");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('events', 'cod_event, name, start_at, end_at', 'cod_event='.$id);
    echo json_encode($res);
}

function loadEvents($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('events', 'cod_event, name, start_at, end_at, event_type', 'clinic='.$id);
    echo json_encode($res);
}

function checkEventDate($startDate, $endDate, $id){
    $db = new DatabaseConnection();
    $count = 0;
    $resStart = $db->filtered_query("events", "count(*) amount", "STR_TO_DATE('{$startDate}', '%Y-%m-%dT%T:%i') between start_at and end_at and clinic={$_SESSION['codClinic']} and cod_event != {$id}");
    $resEnd = $db->filtered_query("events", "count(*) amount", "STR_TO_DATE('{$endDate}', '%Y-%m-%dT%T:%i') between start_at and end_at and clinic={$_SESSION['codClinic']} and cod_event != {$id}");
    if(count($resStart) > 0 && count($resEnd) > 0){
        echo intval($resStart[0]['amount'])+intval($resEnd[0]['amount']);
    }else{
        echo 0;
    }
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('events', 'cod_event='.$id);
    echo json_encode($res);
}


function query(){
    $db = new DatabaseConnection();
    $res = $db->blankectOQuery('medicines', 'row_number() over (order by cod_medicine) id_medicine, cod_medicine, description', 'cod_medicine');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sc':
        echo save($_POST['ID']);
        break;
    case 'ec':
        load($_POST['ID']);
        break;
    case 'dc':
        delete($_POST['ID']);
        break;
    case 'cde':
        checkEventDate($_POST['start'], $_POST['end'], $_POST['ID']);
        break;
    default:
        loadEvents($_SESSION['codClinic']);
}