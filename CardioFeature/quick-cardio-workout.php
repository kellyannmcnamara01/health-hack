<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-11
 * Time: 6:10 PM
 */
ob_start();
session_start();
require_once '../redirect.php';
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

if (isset($_POST['save_workout'])) {

    //grab the variables from the form
    $type = filter_input(INPUT_POST, 'type');
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');


    //validate them
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($type) == false) {
        $type_error = "Name this workout.";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time";
    }
    if ($v->testName($type) == true && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //function to concatenate to appropriate time format

        require_once '../functions/time_format_function.php';
        $time = timeFormat($hours, $minutes, $seconds);


        //insert into database and provide a succcess message.

        //grab the database class.

        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();

        //grab our quick workout class, create an object, set its properties

        require_once '../Models/quickworkout.php';
        $q = new quickworkout();
        $q->setUserId($id);
        $q->setTime($time);
        $q->setDistance($distance);
        $q->setType($type);

        //create a new DAO obect, call its method to insert into quick workouts, pass in our db connnection and quick workout object.
        require_once '../Models/cardioworkoutDAO.php';
        $quick_cardio = new cardioworkoutDAO();
        $quick_cardio->insertQuickCardio($conn, $q);


        //display success message
        $expire = time() + 1;
        setcookie('success', 'Cardio workout logged!', $expire, '/');
        header("Location: Cardio.php");


        //re-set all values

        /*  $type = "";
          $distance = 0;
          $hours = 0;
          $minutes = 0;
          $seconds = 0;
      }*/


    }
}
require_once 'quick-cardio-workout-view.php';
?>