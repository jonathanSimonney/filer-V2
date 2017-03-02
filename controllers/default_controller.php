<?php

require_once 'model/db.php';
require_once 'model/user.php';
require_once 'model/security.php';
require_once 'model/session.php';

function home_action(){
    is_logged_in();
    require('views/home.php');
    $_SESSION['location']['files'] = access_item_in_array($_SESSION['location']['array'],$_SESSION);
    $arrayFiles = $_SESSION['location']['files'];
    //var_dump($arrayFiles, $_SESSION['location'], $_SESSION['files']);
    if ($arrayFiles !== null){
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
    }
    $_SESSION['errorMessage'] = '';
}