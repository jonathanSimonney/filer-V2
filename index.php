<?php
use Router\Router;

session_start();
if (!array_key_exists('errorMessage', $_SESSION)){
    $_SESSION['errorMessage'] = '';
}

require('config/config.php');
require ('config/autoload.php');

if (empty($_GET['action'])){
    $_GET['action'] = 'home';
}

$action = $_GET['action'];


$router = new Router($routes);
$router ->callAction($action);