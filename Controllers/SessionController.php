<?php
require_once '../core/Connection.php';
    function findUser($username, $password){
        $db = new DatabaseConnection();
        $res = $db->filtered_query('users a', 'a.username, a.password, a.first_name, a.second_name, a.last_name, a.family_name, a.creation_date, a.last_pass_up', "username='{$username}' AND password=md5('{$password}')");
        return $res;
    }

    function insUser($user, $password, $firstName, $secondName, $lastName, $familyName, $creationDate, $lastPassUpdate){
        $db = new DatabaseConnection();
        $res = $db->insert('users', 
                            'username, password, first_name, second_name, last_name, family_name, creation_date, last_pass_up',
                            "'{$user}', md5('{$password}'), '{$firstName}', '{$secondName}', '{$lastName}', '{$familyName}', now(), now()");
        echo $res;
    }

    if(isset($_POST['function'])){
        switch($_POST['function']){
            case 'L':
                $user = findUser($_POST['username'], $_POST['password']);
                if (isset($user[0]['username']) && strlen($user[0]['username'])>0){
                    session_start();
                    $_SESSION['user'] = $user[0]['username'];
                    $_SESSION['firstName'] = $user[0]['first_name'];
                    $_SESSION['secondName'] = $user[0]['second_name'];
                    $_SESSION['lastName'] = $user[0]['last_name'];
                    $_SESSION['familyName'] = $user[0]['family_name'];
                    // $_SESSION['secondName'] = $user['second_name']; 
                    // TODO: add role code
                    $error = array( "success" => "Loggin success", "err" => "");
                    echo json_encode($error);
                    
                } else {
                    session_start();
                    session_unset();
                    session_destroy();
                    $error = array( "success" => "", "err" => "User or password incorrect");
                    echo json_encode($error);
                }
                break;
        }
    }