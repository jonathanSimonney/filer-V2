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
    }elseif(get_what_how($fileInformations['path'],'pathFile', 'files')){
        var_dump(get_what_how($fileInformations['path'],'pathFile', 'files'));
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



function upload_this_file($file, $name){
    $fileInformations = format_file_info($file, $name);
    if (is_upload_possible($file, $fileInformations)){
        //make_upload($file, $name);
        echo 'upload done!';
    }else{
        echo $_SESSION['errorMessage'];
    }


    /*<?php
    $_SESSION["errorMessage"] = "";
    $file = $_FILES["file"];
    $nameFile = $_POST["name"];

    if ($_SESSION["errorMessage"] == "") {

        $type = str_replace(".", "", $type);


        if (!move_uploaded_file($file["tmp_name"], $pathFile)){
            $_SESSION["errorMessage"] = "your file wasn't uploaded. Please try seeing if your username is a valid one.";
        }else{
            try{
                $db = new PDO("mysql:host=localhost;dbname=filer","root","password");

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $request = "INSERT INTO `files` (`id`, `nameFile`, `pathFile`, `fileType`, `user_id`) VALUES (NULL, :nameFile, :pathFile, :fileType, ".$_SESSION["idUser"].");";

                $statement = $db->prepare($request);



                $statement->execute([
                    'nameFile' => $nameFile,
                    'pathFile' => $pathFile,
                    'fileType' => $type
                ]);

                $db = null;
            }

            catch(PDOException $e){
                echo $e;
            }
        }
    }




    header("Location: ../../../../pages/connected/listFiles.php");
    exit();*/
}