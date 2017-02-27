<?php

session_start();
if (!array_key_exists('errorMessage', $_SESSION)){
    $_SESSION['errorMessage'] = '';
}

require('config/config.php');

if (empty($_GET['action'])){
    $action = 'home';
}else{
    $action = $_GET['action'];
}

if (isset($routes[$action])){
    require('controllers/'.$routes[$action].'_controller.php');
    call_user_func($action.'_action');
}
else{
    die('Illegal route');
}