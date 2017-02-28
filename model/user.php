<?php

require_once 'model/db.php';
require_once 'model/form_check.php' ;

function is_logged_in(){
    if (!$_SESSION['currentUser']['loggedIn']){
        $_SESSION['errorMessage'] = 'Sorry, but you tried to access a page without authorisation. Please log in.';
        header('Location: ?action=login');
        exit(0);
    }
}

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
    $user = get_what_how($data['username'], 'username', 'users')[0];
    $_SESSION['currentUser']['data'] = $user;//currently useless, but could be used later to pre-fill login field or something else.
    $_SESSION['currentUser']['loggedIn'] = false;

    mkdir('uploads/'.$user['id']);//create folder for user file
}

function user_check_login($data){
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
