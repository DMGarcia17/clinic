<?php
define ('SITE_ROOT', realpath(dirname(__FILE__)));
require_once '../core/Connection.php';
function delete($id, $name){
    $target = SITE_ROOT."\\..\\files\\{$name}";
    if(unlink($target)){
        $db = new DatabaseConnection();
        $res = $db->delete('files', 'cod_file='.$id);
        echo json_encode($res);
    }else{
        echo "error_file_delete";
    }
}


function query(){
    $db = new DatabaseConnection();
    $res = $db->filteredOQuery('files', 'row_number() over (order by cod_file) id_file, cod_file, cod_patient, cod_appointment, name', "cod_appointment={$_GET['a']}", 'cod_file');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'df':
        delete($_POST['ID'], $_POST['name']);
        break;
    default:
        query();
}