<?php
require_once '../core/Connection.php';
function saveState($id){
    $db = new DatabaseConnection();
    
    if ($id == null) {
        $res = $db->insert('states', 'state, description, user_add', "'{$_POST['state']}', '{$_POST['description']}', session_user()");
    }else{
        $res = $db->update('states', "state='{$_POST['state']}'", "description='{$_POST['description']}', state='{$_POST['state']}'");
    }
    return $res;
}

function loadState($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('states a', 'a.state, a.description, a.user_add', "state='{$id}'");
    echo json_encode($res);
}

function delState($id){
    $db = new DatabaseConnection();
    $res = $db->delete('states', "state='{$id}'");
    echo json_encode($res);
}

function queryStates(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('states a', 'a.state, a.description');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 's':
        echo saveState($_POST['userAdd']);
        break;
    case 'e':
        loadState($_POST['state']);
        break;
    case 'd':
        delState($_POST['state']);
        break;
    default:
        queryStates();
}