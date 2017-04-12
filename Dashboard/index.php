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

$currentPage = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . '?access_token=' . $_GET['access_token'];

//$access_token = $_GET['access_token'];
// include project files (check if files are already included, if they are, won't include require them again)
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
require_once '../Common Views/Header.php';
require_once 'processImg.php';

//create variable to hold current uri
//$currentPage = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

//$test = 'http://localhost/health-hack/index.php?email=bryanstephensdevelopment@gmail.com&access_token=45*0781';

//$test1 = substr($currentPage, strpos($currentPage, "&access_token=") +14);
//echo $test1;

//new instance of Signup()
//$d = new Profile();

//$register = $d->GetUserIdByToken($test1);

//$registerName = $register->first_name;
//echo $registerName;
// est. variable that contains session variable for email
$user = $_SESSION['user'];

if($_SERVER['HTTP_REFERER'] === 'landing.php')
{
    echo "previously at landing.php";
}
else
{
    echo "I don't know where I came from";
}

// call userInfo() method
$userId = $db->userInfo($user);
//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . '&' . $userId->last_name;

if (isset($_POST['profileSubmit'])){
    $file_error = $_FILES['profileImg']['error'];
    $file_size = $_FILES['profileImg']['size'];
    $file_name = $_FILES['profileImg']['name'];

    // form values
    $age = filter_input(INPUT_POST, "ProfileAge");
    $weight = filter_input(INPUT_POST, "ProfileWeight");

    // call Image validation function(s)
    $img_error = ImgCode($file_error);
    $img_size = ImgSize($file_size);

    if($img_size === true && $img_error == true){
        // call ImgPath()
        //$img_name = ImgPath($file_name,$userName);
        //folder to move the uploaded file . "user?" . $userName . "/"
        $target = "ProfileImages/";
        //var_dump($_FILES["profileImg"]["tmp_name"]);
        //$target_path = $target_path .  $file_name;
        //var_dump($img_name);
        // move_uploaded_file()
        move_uploaded_file($_FILES['profileImg']['tmp_name'], $target.$file_name);
        // new instance of Profile
        $signup = new Profile();
        $signup->UserInfo($id,$age,$weight,$file_name);
    }

}

?>
<div class="container">
    <div id="main-content" class="col-12">
        <h2 class="h2 col col-md-8"><?php if(isset($userFirst)){ echo $userFirst; } ?>'s Dashboard</h2>
        <p class="text-primary col col-md-8">Update your age, weight, and profile image below</p>
<!--         <p>--><?php //echo $currentPage;?><!--</p>-->
    <!-- form to update user profile information -->
    <!-- since user will upload an image, set enctype on form -->
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
<?php
require_once '../Common Views/Footer.php';
?>