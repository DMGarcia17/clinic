<?php
require_once '../core/Connection.php';
    function findUser($username, $password){
        $db = new DatabaseConnection();
        $res = $db->filtered_query('users a', 'a.username, a.password, a.complete_name, a.cod_rol, a.add_date, a.user_add, a.mod_date, a.user_mod, a.last_pass_up', "username='{$username}' AND password=md5('{$password}')");
        return $res;
    }

    function insUser($user, $password, $completeName, $creationDate, $lastPassUpdate){
        $db = new DatabaseConnection();
        $res = $db->insert('users', 
                            'username, password, complete_name, cod_rol, add_date, user_add, mod_date, user_mod, last_pass_up',
                            "'{$user}', md5('{$password}'), '{$completeName}', now(), now()");
        echo $res;
    }

    if(isset($_POST['function'])){
        $function = $_POST['function'];
    }else if(isset($_GET['function'])){
        $function = $_GET['function'];
    }
    if(isset($function)){
        switch($function){
            case 'L':
                $user = findUser($_POST['username'], $_POST['password']);
                if (isset($user[0]['username']) && strlen($user[0]['username'])>0){
                    session_start();
                    $_SESSION['user'] = $user[0]['username'];
                    $_SESSION['completeName'] = $user[0]['complete_name'];
                    $_SESSION['codRol'] = $user[0]['cod_rol'];
                    $_SESSION['codClinic'] = 1;
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
            case 'D':
                session_start();
                session_unset();
                session_destroy();
                header("Location: http://localhost/clinic/login.php?error=0"); 
        }
    }