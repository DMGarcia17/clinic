<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('medicines', 'description, chemical_compound, indication', "'{$_POST['medicine']}','{$_POST['chemicalCompound']}','{$_POST['indication']}'");
    }else{
        $res = $db->update('medicines', "cod_medicine={$_POST['ID']}", "description='{$_POST['medicine']}',chemical_compound='{$_POST['chemicalCompound']}',indication='{$_POST['indication']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('medicines', 'cod_medicine, description, chemical_compound, indication', 'cod_medicine='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('medicines', 'cod_medicine='.$id);
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