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

    return get_array_returned($errorMessage);
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
    $_SESSION['currentUser'] = $user;

    mkdir('web/uploads/'.$user['id']);//create folder for user file
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
