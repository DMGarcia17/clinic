<?php
require_once '../core/Connection.php';
function saveSummary($id){
    $db = new DatabaseConnection();
    
    if ($id == null) {
        $res = $db->insert('daily_log', 'file, registration_date, details, state', "'{$_POST['file']}', str_to_date('{$_POST['registrationDate']}', '%Y-%m-%dT%H:%i:%s'), '{$_POST['details']}', '{$_POST['state']}'");
    }else{
        $res = $db->update('daily_log', "ID={$_POST['ID']}", "file='{$_POST['file']}', registration_date=str_to_date('{$_POST['registrationDate']}', '%Y-%m-%dT%H:%i:%s'), details='{$_POST['details']}', state='{$_POST['state']}'");
    }
    return $res;
}

function loadSummary($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('daily_log a', 'a.ID, a.file, a.registration_date, a.details, a.state', 'ID='.$id);
    echo json_encode($res);
}

function delSummary($id){
    $db = new DatabaseConnection();
    $res = $db->delete('daily_log', 'ID='.$id);
    echo json_encode($res);
}

function querySummaries(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('daily_log a', 'a.ID, (select name from files where id=a.ID) file, date_format(a.registration_date, \'%d/%m/%Y %H:%m:%s\') registration_date, a.details, (select description from states s where state=a.state) state');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 's':
        echo saveSummary($_POST['ID']);
        break;
    case 'e':
        loadSummary($_POST['ID']);
        break;
    case 'd':
        delSummary($_POST['ID']);
        break;
    default:
        querySummaries();
}