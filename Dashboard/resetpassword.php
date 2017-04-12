<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-12
 * Time: 12:56 PM
 */
//start session
session_start();
//include the header & sidebar
require_once "../Common Views/Header.php";
require_once "../Common Views/sidebar.php";

// check if $_GET paramaters exist on incoming URI
if (isset($_GET['access_token'])) {
    $test = $_GET['access_token'];
    // var to hold URI from GET request (from email)
    $emailRefer = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    // set var to hold the value of the access_token from specific request
    $access_token = substr($emailRefer, strpos($emailRefer, "rest_token=") +13);
    //echo $access_token;

    // new instance of Profile()
    $db = new Profile();

    // call GetUserIdByToken()
    $profile = $db->GetUserIdByToken($access_token);

    // initialize new SESSION variable
    $_SESSION['user'] = $profile->user_id;
    // set $user to $_SESSION['user']
    $user = $_SESSION['user'];
}else{
    $test = '';
}
