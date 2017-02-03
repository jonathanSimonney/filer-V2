<?php

require_once('model/user.php');

function home_action()
{
    if (!empty($_SESSION['user_id']))
    {
        $user = get_user_by_id($_SESSION['user_id']);
        //$user = get_user_by_id(1);
        $username = $user['username'];
        require('views/home.php');
    }
    else {
        header('Location: ?action=login');
        exit(0);
    }
}

function about_action()
{
    require('views/about.html');
}

function contact_action()
{
    require('views/contact.html');
}
