<?php

require_once "model/file.php";

function upload_action(){
    upload_this_file($_FILES['file'], $_POST['name']);//todo : make this with asynchronous, to avoid reload of home page with only one file changed.
}