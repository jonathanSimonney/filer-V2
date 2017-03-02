<?php

require_once 'model/db.php';
require_once 'model/user.php';
require_once 'model/security.php';

function home_action(){
    is_logged_in();
    require('views/home.php');
    $arrayFiles = $_SESSION['files'];
    $numberForId = 0;
    foreach ($arrayFiles as $key => $value){
        $numberForId++;
        if ($value['type'] === ''){
            require 'views/inc/folder.php';
        }else{
            require 'views/inc/file.php';
        }
    }
    for ($i = 0;$i !== 2;$i++){
        require 'views/inc/divClosure.html';
    }
    require 'views/inc/fileEnd.html';
    $_SESSION['errorMessage'] = '';
}