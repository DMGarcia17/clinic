<?php
require_once '../core/Connection.php';
require_once __DIR__.'/../plugins/vendor/autoload.php';
function save($id){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('diseases', 'name, oral, description', "'{$_POST['name']}', '{$_POST['oral']}', '{$_POST['description']}'");
    }else{
        $res = $db->update('diseases', "cod_disease={$_POST['ID']}", "name='{$_POST['name']}', oral='{$_POST['oral']}', description='{$_POST['description']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('diseases', 'cod_disease, name, oral, description', 'cod_disease='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('diseases', 'cod_disease='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query('diseases', 'cod_disease, name, oral, description');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

/**
 * Feature: Bulk load of diseases
 */

 function queryRecord($disease){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('diseases', 'cod_disease', "name='{$disease}' limit 1");
    if(isset($res[0]) && intval($res[0]['cod_disease']) > 0){
        return intval($res[0]['cod_disease']);
    }
    return 0;
}

function saveBulkRecord($name, $description, $oral){
    $idDisease = queryRecord($name);
    $db = new DatabaseConnection();
        
    if ($idDisease == 0) {
        $ins = $db->insert('diseases', 'name, oral, description', "'{$name}', '{$oral}','{$description}'");
    }else{
        $ins = $db->update('diseases', "cod_disease={$idDisease}", "description='{$description}',name='{$name}', oral='{$oral}'");
    }
    return $ins;
}

function readExcel($name){
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $reader->setReadDataOnly(true);
    $spreadsheet = $reader->load($name);
    $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
    $data = $sheet->toArray();
    foreach($data as $row){
        saveBulkRecord($row[0], $row[1], $row[3]);
    }
}

function bulkLoad(){
    if (!empty($_FILES)){
        if (is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
            $source = $_FILES['fileUpload']['tmp_name'];
            $fileName = $_FILES['fileUpload']['name'];
            $name=basename($_FILES['fileUpload']['name']);
            $target = __DIR__."/../files/{$name}";
            if(!file_exists($target)){
                if(move_uploaded_file($source, $target)){
                    try{
                        readExcel($target);
                    }catch(Exception $e){
                        echo $e->getMessage();
                    }finally{
                        unlink($target);
                    }
                }
            }else{
                echo "error_file_exists";
            }
        }else{
            echo "Error uploading file";
        }
    }else{
        echo "Files empty";
    }
}

/**
 * End of feature
 */

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sd':
        $result = save($_POST['ID']);
        verifyOrder();
        echo $result;
        break;
    case 'ed':
        load($_POST['ID']);
        break;
    case 'dd':
        delete($_POST['ID']);
        break;
    case 'bl':
        bulkLoad();
        break;
    default:
        query();
}