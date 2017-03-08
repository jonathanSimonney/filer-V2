<?php

function generateAccessMessage($action){
    return 'User '.$_SESSION['currentUser']['data']['username'].$action.' at '.date('r');
}

function writeToLog($newMessage, $file){
    if ($file === 'access'){
        $file = fopen('logs/access.log', 'ab');
    }else{
        $file = fopen('logs/security.log', 'ab');
    }
    fwrite($file, $newMessage.'\n');

    fclose($file);
}