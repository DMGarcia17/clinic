<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('allergies', 'name, pr_order, description', "'{$_POST['name']}', '{$_POST['order']}', '{$_POST['description']}'");
    }else{
        $res = $db->update('allergies', "cod_allergie={$_POST['ID']}", "name='{$_POST['name']}', pr_order='{$_POST['order']}', description='{$_POST['description']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('allergies', 'cod_allergie, name, pr_order, description', 'cod_allergie='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('allergies', 'cod_allergie='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('allergies', 'cod_allergie, name, pr_order, description');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sa':
        echo save($_POST['ID']);
        break;
    case 'ea':
        load($_POST['ID']);
        break;
    case 'da':
        delete($_POST['ID']);
        break;
    default:
        query();
}