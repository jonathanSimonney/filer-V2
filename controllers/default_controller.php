<?php

require_once 'model/db.php';
require_once 'model/user.php';
require_once 'model/security.php';
require_once 'model/session.php';

function home_action(){
    is_logged_in();
    $_SESSION['location']['files'] = get_item_in_array($_SESSION['location']['array'],$_SESSION);
    $arrayElements = $_SESSION['location']['files'];

    if ($_SESSION['location']['simple'] === 'root'){
        $link = '<p> </p><a href="?action=logout"><i class="fa fa-power-off" aria-hidden="true"></i>log&nbsp;out</a>';
    }else{
        $link = '<a href="?action=to_parent" class="precedent clickable"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> <a href="?action=logout"><i class="fa fa-power-off" aria-hidden="true"></i>log&nbsp;out</a>';
    }
    require('views/home.php');
    //var_dump($arrayElements, $_SESSION['location'], $_SESSION['files']);
    if ($arrayElements !== null){
        $numberForId = 0;

        $arrayElements = order_between_files_and_folder($arrayElements);

        foreach ($arrayElements as $key => $value){
            //var_dump(get_real_path_to_file($value));
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