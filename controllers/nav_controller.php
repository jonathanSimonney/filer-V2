<?php
require_once 'model/file.php';
require_once 'model/security.php';
require_once 'model/session.php';


function open_action(){
    $folderInformations = get_file_data($_GET['fileId']);
    if (user_can_access($folderInformations)){
        array_push($_SESSION['location']['array'], $folderInformations['id'], 'childs');
        $_SESSION['location']['simple'] = $folderInformations['id'];
    }
    header('Location: ?action=home');
    exit();
}

function to_parent_action(){
    for ($i = 0;$i !== 3;$i++){
        array_pop($_SESSION['location']['array']);
    }

    $_SESSION['location']['simple'] = array_pop($_SESSION['location']['array']);

    array_push($_SESSION['location']['array'], $_SESSION['location']['simple'], 'childs');

    if ($_SESSION['location']['simple'] === null){
        user_session_location_init();
    }

    header('Location: ?action=home');
    exit();
}