<?php
function home_action(){
    if ($_SESSION['currentUser']['loggedIn']) {
        require('views/home.php');
        $_SESSION['errorMessage'] = '';
    }else{
        $_SESSION['errorMessage'] = 'Sorry, but you tried to access a page without authorisation. Please log in.';
        header('Location: ?action=login');
        exit(0);
    }
}