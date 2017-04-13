<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-12
 * Time: 12:56 PM
 */
//start session
session_start();
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
// new instance of Profile()
$db = new Profile();

// check if $_GET paramaters exist on incoming URI
if (isset($_GET['reset_token'])) {
    $test = $_GET['reset_token'];

    // var to hold URI from GET request (from email)
    $emailRefer = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    // set var to hold the value of the access_token from specific request
    $access_token = substr($emailRefer, strpos($emailRefer, "reset_token") +12);
    //echo $access_token;



    // call GetUserIdByToken()
    $profile = $db->GetUserIdByResetToken($access_token);
    //echo $profile->user_id;
    // initialize new SESSION variable
    $_SESSION['user'] = $profile->user_id;
    //echo $profile->user_id;
    // set $user to $_SESSION['user']
}else{
    $test = 'No get parameter set';
}
$user = $_SESSION['user'];
//echo $user;
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userEmail = $userId->email
//$userFirst = $userId->first_name;
/$userName = $userId->first_name . ' ' . $userId->last_name;
/echo $userName;
//include the header & sidebar
if(isset($_POST['passwordUpDateSubmit'])){
    //echo "Hello World";

    //grab form values
    $password = filter_input(INPUT_POST, "NewPassword");
    $confirmPassword = filter_input(INPUT_POST,"PasswordConfirm");

    //confirm user has enter the same password for both fields
    if ($password === $confirmPassword){
        //echo "They match";
        $newPassword = $db->grantPasswordResetToken($password,$id);
        $success = "Password was officially updated for $userEmail";
    }
    else
    {
        $error = "Please ensure both password match.";
    }
}
require_once '../Common Views/Header.php';
require_once "../Common Views/sidebar.php";
?>

    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <h2 class="h2 col col-md-8 text-center">Reset Your Password</h2>
            <p class="text-primary col col-md-8 text-center">Please enter your new password below.</p>
            <p class="text-info col col-md-8 text-center"><?php if (isset($error)){ echo $error;}?></p>
            <p class="text-info col col-md-8 text-center"><?php if (isset($error)){ echo $error;}?></p>
            <form action="resetpassword.php" method="post" id="changeUserPassword">
                <div class="form-field col col-md-8">
                    <label class="formLabel">Password</label>
                    <input type="password" class="textInput" title="Please enter a new " placeholder="New Password" name="NewPassword">
                    <span class="text-info">Please enter a new password</span>
                </div>
                <div class="form-field col col-md-8">
                    <label class="formLabel">Re-enter Password</label>
                    <input type="password" class="textInput"  title="Please enter a valid number" placeholder="Re-enter new password" name="PasswordConfirm">
                    <span class="text-info">Re-enter new password</span>
                </div>
                <div class="form-field col-6 col-md-4">
                    <input type="submit" class="formSubmit" name="passwordUpDateSubmit" value="Submit">
                </div>
            </form>
        </div> <!-- end of main-content div-->
    </div> <!-- end of container div-->
    </main>

<?php
require_once '../Common Views/Footer.php';
?>