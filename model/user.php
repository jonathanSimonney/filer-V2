<?php

require_once('model/db.php');
require_once('model/form_check.php');

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
    global $errorMessage;
    $errorMessage= '';

    check_required_field(['username', 'email', 'password', 'confirmationOfPassword', 'indic']);

    check_uniq_field(['username' => 'users', 'email' => 'users']);

    check_email($_POST['email']);

    check_password($_POST['password'], $_POST['confirmationOfPassword']);

    /*SUPPRESS( put it in user_register)
        if ($errorMessage == ') {
            try{
                $db = new PDO('mysql:host=localhost;dbname=filer','root','password');

                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $request = 'INSERT INTO `users` (`id`, `username`, `password`, `email`, `indicationPassword`) VALUES (:id, :username, :password, :email, :indic);';//BEWARE! not written in the same order than in db.
                $statement = $db->prepare($request);
                $statement->execute([
                    'id' => NULL,
                    'username' => $_POST['username'],
                    'password' => $_POST['password'],
                    'email' => $_POST['email'],
                    'indic' => $_POST['indic']
                ]);
            }

            catch(PDOException $e){
                echo $e;
            }

            $db = null;

            mkdir('../../files/'.htmlspecialchars($_POST['username']));//create folder for user file
    ENDSUPPRESS*/

    return get_array_returned($errorMessage);
}

function user_hash($pass){
    $hash = password_hash($pass, PASSWORD_BCRYPT, ['salt' => 'saltysaltysaltysalty!!']);
    return $hash;
}

function user_register($data){
    $user['username'] = $data['username'];
    $user['password'] = user_hash($data['password']);
    $user['email'] = $data['email'];
    db_insert('users', $user);
}

function user_check_login($data){
    if (empty($data['username']) OR empty($data['password'])){
        return false;
    }
    $user = get_user_by_username($data['username']);
    if ($user === false){
        return false;
    }
    $hash = user_hash($data['password']);
    if ($hash !== $user['password']) {
        return false;
    }
    return true;
}

function user_login($username){
    $data = get_user_by_username($username);
    if ($data === false){
        return false;
    }
    $_SESSION['user_id'] = $data['id'];
    return true;
}
