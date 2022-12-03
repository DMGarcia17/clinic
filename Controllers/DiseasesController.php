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

function findOrder($order){
    $db = new DatabaseConnection();
    $res = $db->filteredOQuery('diseases', 'cod_disease, pr_order', 'pr_order>='.$order, 'pr_order desc');
    if(isset($res[0]['pr_order'])){
        return $res;
    }else{
        return 0;
    }
}

function findCurrentOrder($id){
    $db = new DatabaseConnection();
    $res = $db->filteredOQuery('diseases', 'cod_disease, pr_order', "cod_disease = '{$id}'", 'pr_order desc');
    if(isset($res[0]['pr_order'])){
        return $res;
    }else{
        return 0;
    }
}

function findAllOrdered(){
    $db = new DatabaseConnection();
    $res = $db->blankectOQuery('diseases', '*', 'pr_order asc');
    if(isset($res[0]['pr_order'])){
        return $res;
    }else{
        return 0;
    }
}

function reOrder($id, $order){
    $db = new DatabaseConnection();
    $toFix=findOrder($order);
    $currentItem = findCurrentOrder($id);
    if ($toFix != 0 and $currentItem != 0){
        foreach($toFix as $item){
            if ($order == (intval($currentItem[0]['pr_order']) + 1) || ($item['pr_order'] == $order && $order > $currentItem[0]['pr_order'])){
                $newVal = $item['pr_order']-1;
                $db->update('diseases', "cod_disease={$item['cod_disease']}", "pr_order='{$newVal}'");
            }else{
                $newVal = $item['pr_order']+1;
                $db->update('diseases', "cod_disease={$item['cod_disease']}", "pr_order='{$newVal}'");
            }
        }
    }
}

function verifyOrder(){
    $db = new DatabaseConnection();
    $toVerify = findAllOrdered();

    if ($toVerify != 0){
        $currentOrder = 0;
        foreach($toVerify as $row){
            if($currentOrder == 0 && $row['pr_order'] == 1){
                $currentOrder = 1;
            }else if ($currentOrder == 0 && $row['pr_order'] != 1){
                $currentOrder = 0;
            }
            $next = $currentOrder + 1;

            if ($row['pr_order'] != 1 && $row['pr_order'] != $next){
                $db->update('diseases', "cod_disease={$row['cod_disease']}", "pr_order='{$next}'");
                $currentOrder = $next;
            }elseif ($row['pr_order'] != 1){
                $currentOrder = $next;
            }
        }
    }
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sd':
        reOrder($_POST['ID'], $_POST['order']);
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
    default:
        query();
}