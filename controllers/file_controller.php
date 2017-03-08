<?php

require_once 'model/file.php';
require_once 'model/user.php';
require_once 'model/security.php';
require_once 'model/form_check.php';
require_once 'model/log.php';

is_logged_in();//todo put it into the routing system.(put bool to enable check for connection of user.)

function upload_action(){
    $fileInformations = format_file_info($_FILES['file'], $_POST['name']);
    if (is_upload_possible($_FILES['file'], $fileInformations)) {
        make_upload($_FILES['file'], $fileInformations);
        writeToLog(generateAccessMessage('uploaded file '.$_POST['name'].', of id '.get_last_inserted_id()), 'access');
    }
    header('Location: ?action=home');
    exit();
}

function download_action(){
    $fileData = get_file_data($_GET['fileId']);
    if (user_can_access($fileData)){
        download_file($fileData);
        writeToLog(generateAccessMessage('downloaded file '.get_name_with_extent($fileData['name']).', of id '.$fileData['id']), 'access');
    }
}

function replace_action(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $fileData = get_file_data($_POST['notForUser']);
        if (user_can_access($fileData)){
            if (is_new_file_ok($fileData)){//Did not merge these 2 if because both implement the $_SESSION['errorMessage']
                replace_file(get_real_path_to_file($fileData), $_FILES['file']);
                writeToLog(generateAccessMessage('replaced file '.get_name_with_extent($fileData).', of id '.$fileData['id'].' by another file'), 'access');
            }else{
                writeToLog(generateAccessMessage('wanted to replace file '.get_name_with_extent($fileData).', of id '.$fileData['id'].' by a .'.$fileData['type']), 'access');
            }
        }
    }else{
        writeToLog(generateAccessMessage('tried to access replace page with GET request method.'), 'security');
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
                writeToLog(generateAccessMessage('renamed file (or folder) '.get_name_with_extent($fileData).', of id '.$fileData['id'].' into '.$newFileData['name'].'.'), 'access');
            }else{
                writeToLog(generateAccessMessage('TRIED to rename file (or folder) '.get_name_with_extent($fileData).', of id '.$fileData['id'].' into '.$newFileData['name'].'.'), 'access');
            }
        }
    }else{
        writeToLog(generateAccessMessage('tried to access rename page with GET request method.'), 'security');
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
            writeToLog(generateAccessMessage('erased file or folder '.get_name_with_extent($fileData).' of id '.$fileData['id']), 'access');
        }
    }else{
        writeToLog(generateAccessMessage('tried to access remove page with GET request method.'), 'security');
        $_SESSION['errorMessage'] = 'Please access pages with provided links, not by writing yourself url.';
    }
    header('Location: ?action=home');
    exit();
}

function add_folder_action(){
    $folderInformations = format_folder_info($_POST['name']);
    if (is_name_ok($folderInformations)) {
        //var_dump($folderInformations);
        add_folder($folderInformations);
        writeToLog(generateAccessMessage('created folder '.$folderInformations['name'].', of id '.$folderInformations['id']), 'access');
    }else{
        writeToLog(generateAccessMessage('tried to add a folder of name'.$folderInformations['name']), 'security');
    }

    header('Location: ?action=home');
    exit();
}

function move_action(){
    $movedElementData = get_file_data($_GET['idMovedElement']);
    $toParent = false;
    if ($_GET['idDestination'] === 'precedent'){
        $toParent = true;

        $currentLocation = $_SESSION['location'];

        close_current_folder();
        $destinationId = $_SESSION['location']['simple'];

        close_current_folder();

        $_SESSION['location']['files']= get_item_in_array($_SESSION['location']['array'],$_SESSION);
        $destinationFolderData = get_file_data($destinationId);
        $_SESSION['location'] = $currentLocation;
    }else{
        $destinationFolderData = get_file_data($_GET['idDestination']);
    }
    if (user_can_access($movedElementData) && user_can_access($destinationFolderData, true)){
        $newPath = generate_new_path($movedElementData, $destinationFolderData);

        db_update('files', $movedElementData['id'],['path' => $newPath]);
        move_in_session($movedElementData, $destinationFolderData, $newPath, $toParent);
        move_on_server($movedElementData, $destinationFolderData, $toParent);
        //writeToLog(generateAccessMessage('moved file or folder '.get_name_with_extent($movedElementData['name']).' of id '.$movedElementData['id'].' into folder '.), 'access');
    }


    header('Location: ?action=home');
    exit();
    //TODO check if destination does not have a file of same name.
}

function show_action(){
    $fileData = get_file_data($_GET['id']);
    http_response_code(400);

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if (user_can_access($fileData)){
            if ($fileData['type'] !== ''){
                http_response_code(200);

                $ret = json_encode([
                    'path'  => '?action=show&id='.$_GET['id'],
                    'type'  => $fileData['type']
                ]);
                if ($ret === false){
                    echo json_last_error_msg();
                }else{
                    echo $ret;
                }
            }else{
                //user tried to access one of his folder instead of files
            }
        }
    }else{
        if (user_can_access($fileData)){
            if ($fileData['type'] !== ''){
                $path = get_real_path_to_file($fileData);
                http_response_code(200);
                setCorrectHeader($fileData['type']);
                readfile($path);

            }else{
                //user tried to access one of his folder instead of files
            }
        }else{
            setCorrectHeader('jpg');
            readfile('assets/images/trash_picture.jpg');
        }
    }
}

function write_action(){
    $fileData = get_file_data($_GET['id']);
    http_response_code(400);
    if (user_can_access($fileData)){
        //var_dump($_GET['newContent']);
        file_put_contents(get_real_path_to_file($fileData), $_GET['newContent']);
        http_response_code(200);
        //echo file_get_contents(get_real_path_to_file($fileData));
    }
}