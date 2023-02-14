<?php
require_once '../core/Connection.php';
session_start();
function save($id){
    $db = new DatabaseConnection();
    $pass = isset($_POST['password']) && $_POST['password'] != '' ? "md5('{$_POST['password']}')" : 'password';
    if ($id == null) {
        $res = $db->insert('users', 'username, password, complete_name, default_clinic, add_date, user_add', "'{$_POST['username']}', md5('{$_POST['password']}'), '{$_POST['completeName']}', '{$_POST['defaultClinic']}', now(), '{$_SESSION['user']}'");
    }else{
        $res = $db->update('users', "username='{$_POST['id']}'", "password={$pass}, complete_name='{$_POST['completeName']}', username='{$_POST['username']}', default_clinic='{$_POST['defaultClinic']}', mod_date=now(), user_mod='{$_SESSION['user']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('users a', 'username, complete_name, default_clinic', "username='{$id}'");
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('users', "username='{$id}'");
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankectOQuery('users a', 'a.username, a.complete_name, row_number() over (order by username) id', 'username');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'su':
        echo save($_POST['id']);
        break;
    case 'eu':
        load($_POST['id']);
        break;
    case 'du':
        delete($_POST['id']);
        break;
    default:
        query();
}