<?php

require_once 'model/db.php';

function get_file_data($fileId){
    return get_what_how($fileId, 'id', 'files')[0];
}

function format_new_file_data($oldFileData){
    $newFileData['name'] = format_file_name($_POST['name'], $oldFileData['type']);

    //following regexp is supposed to select the oldFileName only if it is followed by its type with nothing behind.
    $newFileData['path'] = preg_replace('/'.preg_quote($oldFileData['name'], NULL).'(?=\.'.$oldFileData['type'].'(?!=.))/', $newFileData['name'], $oldFileData['path']);
    echo $newFileData['path'].'<br>';
    echo '/'.preg_quote($oldFileData['name'], NULL).'(?=\.'.$oldFileData['type'].'(?!=.))/';
    return $newFileData;
}

function rename_file($oldFileData){
    $newFileData = format_new_file_data($oldFileData);
    rename($oldFileData['path'], $newFileData['path']);
    db_update('files', $oldFileData['id'], $newFileData);
}

function is_new_file_ok($oldFileData){
    if(empty($_FILES['file']['name'])){
        $_SESSION['errorMessage'] = 'You must choose a file to upload.';
        return false;
    }elseif ($oldFileData['type'] !== get_file_type($_FILES['file'])) {
        $_SESSION['errorMessage'] = 'The type of the file you wish to replace is not the same as the one you wish to upload instead)';
        return false;
    }
    return true;
}

function replace_file($pathOldFile, $file){
    if (!move_uploaded_file($file["tmp_name"], $pathOldFile)){
        $_SESSION["errorMessage"] = "your file wasn't uploaded. Please try seeing if your username is a valid one.";
    }
}

function download_file($fileData){
    // Specify file path.
    $download_file =  $fileData['path'];
    // Getting file extension.
    $extension = $fileData['type'];
    // For Gecko browsers
    header('Content-Transfer-Encoding: binary');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime(str_replace($fileData['name'].'.'.$extension, '', $download_file))) . ' GMT');
    // Supports for download resume
    header('Accept-Ranges: bytes');
    // Calculate File size
    header('Content-Length: ' . filesize($download_file));
    header('Content-Encoding: none');
    // Change the mime type if the file is not PDF
    header('Content-Type: application/' . $extension);
    // Make the browser display the Save As dialog
    header('Content-Disposition: attachment; filename=' . $fileData['name'].'.'.$extension);
    readfile($download_file);
    exit;
}

function format_file_name($nameFile, $type){
    $nameFile = preg_replace('/'.$type.'(?!=.)/', '', $nameFile);
    $nameFile = urlencode($nameFile);
    return $nameFile;
}

function get_file_type($file){
    $type = '';
    if (!empty($file['name'])){
        preg_match('/\.[0-9a-z]+$/', $file["name"], $cor);
        $type = $cor[0];
    }

    $type = str_replace(".", "", $type);
    return $type;
}

function format_file_info($file, $nameFile){
    $type = get_file_type($file);

    $nameFile = format_file_name($nameFile, '.'.$type);
    $pathFile = 'uploads/'.$_SESSION['currentUser']['data']['id'].'/'.$nameFile.'.'.$type;

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