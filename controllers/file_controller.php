<?php

require_once "model/file.php";
require_once 'model/user.php';


function upload_action(){
    is_logged_in();
    $fileInformations = format_file_info($_FILES['file'], $_POST['name']);/*todo either forbid .php files OR replace extension + same for
     name with /.*/
    if (is_upload_possible($_FILES['file'], $fileInformations)) {
        make_upload($_FILES['file'], $fileInformations);
    }

    header('Location: ?action=home');
    exit();

    //todo : make this with asynchronous, to avoid reload of home page with only one file changed.
}

function download_action(){
    is_logged_in();
    $fileData = get_file_data($_GET['fileId']);
    if ($fileData['user_id'] === $_SESSION['currentUser']['data']['id']){
        download_file($fileData);
    }
}