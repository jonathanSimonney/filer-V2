<?php

require_once "model/file.php";

function upload_action(){
    $fileInformations = format_file_info($_FILES['file'], $_POST['name']);
    if (is_upload_possible($_FILES['file'], $fileInformations)) {
        make_upload($_FILES['file'], $fileInformations);
    }

    header('Location: ?action=home');
    exit();

    //todo : make this with asynchronous, to avoid reload of home page with only one file changed.
}