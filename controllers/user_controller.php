<?php

require_once('model/user.php');

function login_action(){
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (user_check_login($_POST)) {
            user_login($_POST['username']);
        }else{
            $jsonValue = $_SESSION['errorMessage'];
            require('views/inc/json.php');
            $_SESSION['errorMessage'] = '';
        }
    }else{
        require('views/login.php');
    }
}

function logout_action(){
    session_destroy();
    header('Location: ?action=login');
    exit(0);
}


function register_action(){
    $error = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $arrayReturned = user_check_register($_POST);
        if ($arrayReturned['formOk']){
            user_register($_POST, ['username', 'email', 'password', 'indic']);
        }
        $jsonValue = $arrayReturned;
        require('views/inc/json.php');
    }else{
        require('views/register.php');
    }
}
