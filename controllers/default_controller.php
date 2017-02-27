<?php
function home_action(){
    if ($_SESSION['currentUser']['loggedIn']) {
        require('views/home.php');
    }else{
        header('Location: ?action=login');
        exit(0);
    }
}