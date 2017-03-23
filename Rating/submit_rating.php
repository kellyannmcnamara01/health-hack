<?php
/*Created By Rahul Malik*/
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;  //get it from session
$ModuleID=1;//get it from feature which is integrating this feature this system
if (isset($_POST['submit_rating']))
{
    //save the values

    $Description = filter_input(INPUT_POST, 'Description');
    $ModuleID = $_POST['ModuleID'];
    $RatNum = $_POST['RatNum'];
    $UserID = $user_id;

    require_once '../Models/Rating.php';
    $RatingObj = new Rating();
    $RatingObj->AddRating($UserID,$RatNum,$ModuleID,$Description);
    $Message = "Your rating has been saved to the system!";
    echo($Message);
	
}
?>