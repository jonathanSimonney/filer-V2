<?php

require_once 'model/db.php';

function format_file_info($file, $nameFile){
    $type = '';
    if (!empty($file['name'])){
        preg_match('/\.[0-9a-z]+$/', $file["name"], $cor);
        $type = $cor[0];
    }

    $nameFile = preg_replace('/'.$type.'(?!=.)/', '', $nameFile);
    $pathFile = 'uploads/'.$_SESSION['currentUser']['data']['id'].'/'.$nameFile.$type;
    $type = str_replace(".", "", $type);

    return [
        'type' => $type,
        'name' => $nameFile,
        'path' => $pathFile
    ];
}

function is_upload_possible($file, $fileInformations){
    $_SESSION['errorMessage'] = '';

    if ($fileInformations['name'] === '') {
        $_SESSION['errorMessage'] = 'You must put a name on your file.';
    }elseif(get_what_how($fileInformations['path'],'path', 'files')){
        $_SESSION['errorMessage'] = 'The name '.$fileInformations['name'].' is already used for one of your files. Please type another name or use the replace button.';
    }elseif(empty($file['name'])){
        $_SESSION['errorMessage'] = 'You must choose a file to upload.';
    }

    if ($_SESSION['errorMessage'] === ''){
        return true;
    }else{
        return false;
    }
}

function upload_file_in_folder($file, $fileInformations){
    if (!move_uploaded_file($file['tmp_name'], $fileInformations['path'])){
        $_SESSION['errorMessage'] = "your file wasn't uploaded. Please try seeing if your username is a valid one.";
        return false;
    }else{
        return true;
    }
}

function upload_file_in_db($fileInformations){
    $fileInformations['user_id'] = $_SESSION['currentUser']['data']['id'];
    db_insert('files', $fileInformations, true);
}


function make_upload($file, $fileInformations){
    if (upload_file_in_folder($file, $fileInformations)){
        upload_file_in_db($fileInformations);
    }
}