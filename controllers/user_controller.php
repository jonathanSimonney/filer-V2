<?php

require_once('model/user.php');

function login_action(){
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
        if (array_key_exists('currentUser', $_SESSION)){
            if ($_SESSION['currentUser']['loggedIn']){
                session_destroy();
                session_start();
            }
        }
        $_SESSION['errorMessage'] = '';
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