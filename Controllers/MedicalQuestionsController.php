<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('medical_conditions', 'question, question_type', "'{$_POST['question']}', '{$_POST['pquestion']}'");
    }else{
        $res = $db->update('medical_conditions', "cod_medical={$_POST['ID']}", "question='{$_POST['question']}', question_type='{$_POST['pquestion']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('medical_conditions', 'cod_medical, question, question_type', 'cod_medical='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('medical_conditions', 'cod_medical='.$id);
    echo json_encode($res);
}


function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('medical_conditions', 'cod_medical, question, question_type');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sm':
        echo save($_POST['ID']);
        break;
    case 'em':
        load($_POST['ID']);
        break;
    case 'dm':
        delete($_POST['ID']);
        break;
    default:
        query();
}