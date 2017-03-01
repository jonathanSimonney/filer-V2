<?php

function user_can_access($fileData){
    if($fileData['user_id'] === $_SESSION['currentUser']['data']['id']){
        return true;
    }else{
        //todo : writ in .log, make different errorMessage etc.
        $_SESSION['errorMessage'] = 'You tried to access a file which wasn\'t one of your files.';
        return false;
    }
}

function is_logged_in(){
    if (!$_SESSION['currentUser']['loggedIn']) {
        $_SESSION['errorMessage'] = 'Sorry, but you tried to access a page without authorisation. Please log in.';
        header('Location: ?action=login');
        exit(0);
    }
}