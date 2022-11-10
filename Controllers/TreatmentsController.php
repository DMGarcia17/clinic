<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('treatments', 'name, pr_order, description, show_rp, paediatric_treatment', "'{$_POST['name']}', '{$_POST['order']}', '{$_POST['description']}', '{$_POST['showRP']}', '{$_POST['ptreatment']}'");
    }else{
        $res = $db->update('treatments', "cod_treatment={$_POST['ID']}", "name='{$_POST['name']}', pr_order='{$_POST['order']}', description='{$_POST['description']}', show_rp='{$_POST['showRP']}', paediatric_treatment='{$_POST['ptreatment']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('treatments', 'cod_treatment, name, pr_order, description, show_rp, paediatric_treatment ptr', 'cod_treatment='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('treatments', 'cod_treatment='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('treatments', 'cod_treatment, name, pr_order, description');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'st':
        echo save($_POST['ID']);
        break;
    case 'et':
        load($_POST['ID']);
        break;
    case 'dt':
        delete($_POST['ID']);
        break;
    default:
        query();
}