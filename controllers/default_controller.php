<?php

require_once('model/user.php');

function home_action(){
    if (!empty($_SESSION['user_id'])) {
        require('views/home.php');
    }
    else{
        header('Location: ?action=login');
        exit(0);
    }
}

function about_action(){
    require('views/about.html');
}

function contact_action(){
    require('views/contact.html');
}
