<?php
require_once '../core/Connection.php';
require_once __DIR__.'/../plugins/vendor/autoload.php';
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

/**
 * 
 */


function queryRecord($medicine){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('medicines limit 1', 'cod_medicine', 'description='.$medicine);
    if(intval($res[0]['cod_medicine']) > 0){
        return intval($res[0]['cod_medicine']);
    }
    return 0;
}

function saveBulkRecord($description, $chemicalCompound, $indication){
    $idMedicine = queryRecord($description);
    $db = new DatabaseConnection();
        
    if ($idMedicine == 0) {
        $ins = $db->insert('medicines', 'description, chemical_compound, indication', "'{$description}','{$chemicalCompound}','{$indication}'");
    }else{
        $ins = $db->update('medicines', "cod_medicine={$idMedicine}", "description='{$description}',chemical_compound='{$chemicalCompound}',indication='{$indication}'");
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
        #echo "{$row[0]}|{$row[1]}|{$row[2]}</br>";
        saveBulkRecord($row[0], $row[1], $row[2]);
    }
}

function bulkLoad(){
    if (!empty($_FILES)){
        if (is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
            $source = $_FILES['fileUpload']['tmp_name'];
            $fileName = $_FILES['fileUpload']['name'];
            $name=basename($_FILES['fileUpload']['name']);
            $target = __DIR__."/files/{$name}";
            if(!file_exists($target)){
                if(move_uploaded_file($source, $target)){
                    readExcel($target);
                    unlink($target);
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
    case 'bl':
        bulkLoad();
        break;
    default:
        query();
}