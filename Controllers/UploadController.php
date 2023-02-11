<?php
require_once '../core/Connection.php';
function saveState($idPatient, $idApp, $name){
    $db = new DatabaseConnection();
    
    $res = $db->insert('files', 'cod_patient, cod_appointment, name', "'{$idPatient}', {$idApp}, '{$name}'");
    return $res;
}
define ('SITE_ROOT', realpath(dirname(__FILE__)));
if (!empty($_FILES)){
    if (is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
        $source = $_FILES['fileUpload']['tmp_name'];
        $fileName = $_FILES['fileUpload']['name'];
        $name=basename($_FILES['fileUpload']['name']);
        $target = SITE_ROOT."\\..\\files\\{$name}";
        if(!file_exists($target)){
            if(move_uploaded_file($source, $target)){
                $appointment = ($_POST['idApp'] == '0') ? null : ("'".$_POST['idApp']."'");
                echo saveState($_POST['idPatient'], $appointment, $fileName);
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