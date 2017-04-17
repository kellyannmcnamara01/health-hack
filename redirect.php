<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-14
 * Time: 4:02 PM
 */

if(!isset($_SESSION['user'])){
    header("Location:/health-hack/landing.php");
}

$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;

$profile = new Profile();

$results = $profile->getUserProfileIinfo($id);
$age = $results->age;
$weight = $results->weight;

$img = $profile->getUserProfileImg($id)->profile_image;