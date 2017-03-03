<?php
require_once 'model/nav.php';


function open_action(){
    open_folder($_GET['fileId']);
    header('Location: ?action=home');
    exit();
}

function to_parent_action(){
    close_current_folder();

    header('Location: ?action=home');
    exit();
}