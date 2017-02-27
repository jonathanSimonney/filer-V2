<?php

require_once 'model/db.php';

function home_action(){
    if ($_SESSION['currentUser']['loggedIn']) {
        require('views/home.php');
        $arrayFiles = get_what_how($_SESSION['currentUser']['data']['id'],'user_id','files');
        $numberForId = 0;
        foreach ($arrayFiles as $key => $value){
            $numberForId++;
            require 'views/inc/file.php';
        }
        for ($i = 0;$i !== 2;$i++){
            require 'views/inc/divClosure.html';
        }
        require 'views/inc/fileEnd.html';
        $_SESSION['errorMessage'] = '';
    }else{
        $_SESSION['errorMessage'] = 'Sorry, but you tried to access a page without authorisation. Please log in.';
        header('Location: ?action=login');
        exit(0);
    }
}