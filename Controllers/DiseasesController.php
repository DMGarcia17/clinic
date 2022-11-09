<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('diseases', 'name, pr_order, description', "'{$_POST['name']}', '{$_POST['order']}', '{$_POST['description']}'");
    }else{
        $res = $db->update('diseases', "cod_disease={$_POST['ID']}", "name='{$_POST['name']}', pr_order='{$_POST['order']}', description='{$_POST['description']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('diseases', 'cod_disease, name, pr_order, description', 'cod_disease='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('diseases', 'cod_disease='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('diseases', 'cod_disease, name, pr_order, description');
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