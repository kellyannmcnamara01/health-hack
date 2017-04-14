<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-05
 * Time: 9:41 AM
 * Dashboard/index.php ==> allows users to change their profile information used for Health-hack (weight, profile image); also allows user to input their age
 */
//start session
session_start();


require_once '../Common Views/Header.php';
require_once "../Common Views/sidebar.php";

//$access_token = $_GET['access_token'];
// include project files (check if files are already included, if they are, won't include require them again)
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
require_once 'processImg.php';



$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);


////grab  user id, username
//$id = $userId->user_id;
//$userFirst = $userId->first_name;
//$userName = $userId->first_name . ' ' . $userId->last_name;
//$userEmail = $userId->email;
//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . '&' . $userId->last_name;
$userEmail = $userId->email;

if (isset($_POST['profileSubmit'])){
    $file_error = $_FILES['profileImg']['error'];
    $file_size = $_FILES['profileImg']['size'];
    $file_name = $_FILES['profileImg']['name'];

    //newFileName ==> userFirst & userId
    $newFileName = basename($_FILES['profileImg']['name']);
    print_r($newFileName);
    // form values
    $age = filter_input(INPUT_POST, "ProfileAge");
    $weight = filter_input(INPUT_POST, "ProfileWeight");

    // call Image validation function(s)
    $img_error = ImgCode($file_error);
    $img_size = ImgSize($file_size);

    if($img_size === true && $img_error == true){
        //folder to move the uploaded file . "user?" . $userName . "/"
        $target = "ProfileImages/";
        // move_uploaded_file()
        move_uploaded_file($_FILES['profileImg']['tmp_name'], $target.$file_name);
        // new instance of Profile
        $signup = new Profile();
        $signup->UserInfo($id,$age,$weight,$file_name);
    }

}
?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <h2 class="h2 col col-md-8"><?php if(isset($userFirst)){ echo $userFirst; } ?>'s Dashboard</h2>
        <p class="text-primary col col-md-8">Update your age, weight, and profile image below</p>
        <form action="index.php" method="post" enctype="multipart/form-data" id="updateProfileInformation">
            <div class="form-field col col-md-8">
                <label class="formLabel">Age</label>
                <input class="textInput" title="Please enter a valid number" placeholder="Age" name="ProfileAge">
                <span class="text-info">Please enter your age</span>
            </div>
            <div class="form-field col col-md-8">
                <label class="formLabel">Weight</label>
                <input class="textInput"  title="Please enter a valid number" placeholder="Weight" name="ProfileWeight">
                <span class="text-info">Please enter your weight</span>
            </div>
            <div class="form-field col col-md-8">
                <label class="formLabel">Upload Profile Image</label>
                <input class="textInput" type="file" name="profileImg">
                <span class="text-info">Please select an image to display for your profile</span>
            </div>
            <div class="form-field col-6 col-md-4">
                <input type="submit" class="formSubmit" name="profileSubmit" value="Submit">
            </div>
        </form>
    </div> <!-- end of main-content div-->
</div> <!-- end of container div-->
</main>

<?php
require_once '../Common Views/Footer.php';
?>