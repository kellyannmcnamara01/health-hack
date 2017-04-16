<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-16
 * Time: 2:59 PM
 */

//start session
session_start();


require_once '../Models/Signup.php';
require_once '../Models/Profile.php';




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

require_once '../Common Views/Header.php';
require_once "../Common Views/sidebar.php";
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <h2 class="h2 col col-md-8 text-center"><?php if(isset($userFirst)){ echo $userFirst; } ?>'s Friends</h2>
        <div class="row">
        <!-- Add a friend -->
            <div class="col-x-6">
                <div class="text-center">
                    <h4 class="h3">Add A Friend</h4>
                    <p class="text-primary">Please enter the name of your friend below</p>
                    <form action="Friends.php" method="post" id="changeUserPassword">
                        <div class="form-field">
                            <label class="formLabel">Friends Name</label>
                            <input type="text" class="textInput" title="Name of Friend" placeholder="Name of Friends" name="FriendsName">
                        </div>
                        <div class="form-field">
                            <input type="submit" class="formSubmit" name="addFriend" value="AddFriend">
                        </div>
                    </form>
                    <p class="badge badge-error col col-md-8 text-center"><?php if (isset($error)){ echo $error;}?></p>
                    <p class="text-center badge badge-success col col-md-8 "><?php if (isset($success)){ echo $success;}?></p>
                </div>
            </div>
        <!-- View Friends -->
            <div class="col-x-6">
                <div class="text-center">
                    <h4 class="h3">View Friends</h4>
                    <p class="text-primary">Hello World</p>
                </div>
            </div>
        <!-- Buttons to go back to Root/index.php, Dashboard/Index.php, resetPassword.php -->
        </div>
        <div class="row offset-md-1 offset-sm-1 offset-xs-1">
            <a href="../index.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Home</span>
            </a>
            <a href="./index.php" class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Profile</span>
            </a>
            <a href=resetpassword.php class="btn btn-info btn-lg offset-md-0">
                <span class="glyphicon glyphicon-circle-arrow-left">Reset Password</span>
            </a>
        </div>
    </div> <!-- end of main-content div-->
</div> <!-- end of container div-->
</main>



<?php
require_once '../Common Views/Footer.php';
?>
