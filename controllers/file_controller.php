<?php

require_once 'model/file.php';
require_once 'model/user.php';
require_once 'model/security.php';
require_once 'model/form_check.php';

is_logged_in();//COMMON TO ALL FUNCTION WHO ACT ON FILES!!!

function upload_action(){
    $fileInformations = format_file_info($_FILES['file'], $_POST['name']);
    if (is_upload_possible($_FILES['file'], $fileInformations)) {
        make_upload($_FILES['file'], $fileInformations);
    }

    header('Location: ?action=home');
    exit();
}

function download_action(){
    $fileData = get_file_data($_GET['fileId']);
    if (user_can_access($fileData)){
        download_file($fileData);
    }
}

function replace_action(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fileData = get_file_data($_POST['notForUser']);
        if (user_can_access($fileData)){
            if (is_new_file_ok($fileData)){//Did not merge these 2 if because both implement the $_SESSION['errorMessage']
                replace_file($fileData['path'], $_FILES['file']);
            }
        }
    }else{
        $_SESSION['errorMessage'] = 'Please access pages with provided links, not by writing yourself url.';
    }
    header('Location: ?action=home');
    exit();
}

function rename_action(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fileData = get_file_data($_POST['notForUser']);
        if (user_can_access($fileData)){
            $newFileData = format_new_file_data($fileData);
            if (is_name_ok($newFileData)){
                rename_file($fileData, $newFileData);
            }
        }
    }else{
        $_SESSION['errorMessage'] = 'Please access pages with provided links, not by writing yourself url.';
    }
    header('Location: ?action=home');
    exit();
}

function remove_action(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fileData = get_file_data($_POST['notForUser']);
        if (user_can_access($fileData)){
            suppress_file($fileData);
        }
    }else{
        $_SESSION['errorMessage'] = 'Please access pages with provided links, not by writing yourself url.';
    }
    header('Location: ?action=home');
    exit();
}

function add_folder_action(){
    $folderInformations = format_folder_info($_POST['name']);
    if (is_name_ok($folderInformations)) {
        add_folder($folderInformations);
    }

    header('Location: ?action=home');
    exit();
}

function open_action(){
    $folderInformations = get_file_data($_GET['fileId']);
    if (user_can_access($folderInformations)){
        array_push($_SESSION['location']['array'], $folderInformations['id'], 'childs');
        $_SESSION['location']['simple'] = $folderInformations['id'];
    }
    header('Location: ?action=home');
    exit();
}