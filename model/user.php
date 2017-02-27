<?php

require_once 'model/db.php';
require_once 'model/form_check.php' ;

function get_user_by_id($id){
    $id = (int)$id;
    $data = find_one('SELECT * FROM users WHERE id = '.$id);
    return $data;
}

function get_user_by_username($username){
    $data = find_one_secure('SELECT * FROM users WHERE username = :username',
                            ['username' => $username]);
    return $data;
}

function user_check_register($data){
    $_SESSION['errorMessage'] ='';

    check_required_field(['username', 'email', 'password', 'confirmationOfPassword', 'indic']);
    check_uniq_field(['username' => 'users', 'email' => 'users']);

    check_email($_POST['email']);
    check_password($_POST['password'], $_POST['confirmationOfPassword']);

    return get_array_returned($_SESSION['errorMessage']);
}

function user_hash($pass){
    $hash = password_hash($pass, PASSWORD_BCRYPT);
    return $hash;
}

function transform_data($data){
    $data['password'] = user_hash($data['password']);
    return $data;
}

function user_register($data, $arrayFields){
    $data = transform_data($data);//currently useless (function with only one instruction... But allows easier improvement if in the future one want to add other
    // transformation to data before inscription in db.
    foreach ($arrayFields as $field) {
        $user[$field] = $data[$field];
    }
    db_insert('users', $user);
    $user = get_what_how($data['username'], 'username', 'users');
    $_SESSION['currentUser']['data'] = $user;
    $_SESSION['currentUser']['loggedIn'] = false;

    mkdir('uploads/'.$user['id']);//create folder for user file
}

function user_check_login($data){
    /*
    try{
        $db = new PDO("mysql:host=localhost;dbname=filer","root","password");

        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $request = "SELECT `password`,`indicationPassword` FROM `users` WHERE `users`.`username` = :username;";
        $statement = $db->prepare($request);
        $statement->execute([
            'username' => $_POST["username"]
        ]);

        $arrayResult = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (array_key_exists(0, $arrayResult)) {
            $expectedPassword = $arrayResult[0]["password"];
            if ($expectedPassword == $_POST["password"]) {
                $formOk = true;
                $errorMessage = "";

                session_start();
                $_SESSION["isLoggedIn"] =true;
                $_SESSION["username"] = $_POST["username"];

                $request = "SELECT `id` FROM `users` WHERE `users`.`username` = :username;";
                $statement = $db->prepare($request);
                $statement->execute([
                    'username' => $_POST["username"]
                ]);

                $arrayResult = $statement->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION["idUser"] = $arrayResult[0]["id"];
            }else{
                $formOk = false;
                $errorMessage = "Sorry, but your password does not correspond to your username. Try to take into account the following : ".htmlspecialchars($arrayResult[0]["indicationPassword"]).".";
            }
        }else{
            $formOk = false;
            $errorMessage = "Sorry, but your username is not attributed. Try to type another username.";
        }

        $db = null;
    }

    catch(PDOException $e){
        echo $e;
    }

    $arrayReturned = [$formOk,$errorMessage];
    echo json_encode($arrayReturned);
    */



    $_SESSION['errorMessage'] = '';
    if (empty($data['username']) OR empty($data['password'])){
        $_SESSION['errorMessage'] = 'The fields username and password are required.';
        return false;
    }
    $user = get_user_by_username($data['username']);
    if ($user === false){
        $_SESSION['errorMessage'] = 'Sorry, but the username '.$data['username'].' is not attributed. Try to type another username.';
        return false;
    }

    if (password_verify($data['password'], $user['password'])) {
        return true;
    }
    $_SESSION['errorMessage'] = 'Sorry, but your password does not correspond to your username. Try to take into account the following : '.htmlspecialchars($user['indic']);
    return false;
}

function user_login($username){
    $data = get_user_by_username($username);
    $_SESSION['currentUser']['data'] = $data;
    $_SESSION['currentUser']['loggedIn'] = true;
}
