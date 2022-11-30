<?php
require_once '../core/Connection.php';
function save($id, $name, $order, $description){
    $db = new DatabaseConnection();
    if ($id == null) {
        $res = $db->insert('allergies', 'name, pr_order, description', "'{$name}', '{$order}', '{$description}'");
    }else{
        $res = $db->update('allergies', "cod_allergie={$id}", "name='{$name}', pr_order='{$order}', description='{$description}'");
    }

    echo "id: {$id} name: {$name} order:{$order} description:{$description}";
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

function findOrder($order){
    $db = new DatabaseConnection();
    $res = $db->filteredOQuery('allergies', 'cod_allergie, pr_order', 'pr_order>='.$order, 'pr_order desc');
    if(isset($res[0]['pr_order'])){
        return $res;
    }else{
        return 0;
    }
}

function findCurrentOrder($id){
    $db = new DatabaseConnection();
    $res = $db->filteredOQuery('allergies', 'cod_allergie, pr_order', "cod_allergie = '{$id}'", 'pr_order desc');
    if(isset($res[0]['pr_order'])){
        return $res;
    }else{
        return 0;
    }
}

function findAllOrdered(){
    $db = new DatabaseConnection();
    $res = $db->blankectOQuery('allergies', '*', 'pr_order asc');
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
            if ($item['pr_order'] == (intval($currentItem[0]['pr_order']) + 1)){
                $newVal = $item['pr_order']-1;
                $db->update('allergies', "cod_allergie={$item['cod_allergie']}", "pr_order='{$newVal}'");
            }else{
                $newVal = $item['pr_order']+1;
                $db->update('allergies', "cod_allergie={$item['cod_allergie']}", "pr_order='{$newVal}'");
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
                $db->update('allergies', "cod_allergie={$row['cod_allergie']}", "pr_order='{$next}'");
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
    case 'sa':
        reOrder($_POST['ID'], $_POST['order']);
        $result = save($_POST['ID'], $_POST['name'], $_POST['order'], $_POST['description']);
        verifyOrder();
        echo $result;
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