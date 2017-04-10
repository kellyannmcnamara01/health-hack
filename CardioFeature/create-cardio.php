<?php
ob_start();
session_start();
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

$user_id = 1;
if (isset($_POST['submit_cardio'])){
    //grab inputs from previous form

    $cardio_name = filter_input(INPUT_POST, 'cardio_name');
    $cardio_type = filter_input(INPUT_POST, 'cardio_type');
    $cardio_distance = filter_input(INPUT_POST, 'cardio_distance');
    $cardio_hours =  filter_input(INPUT_POST, 'hours');
    $cardio_minutes = filter_input(INPUT_POST, 'minutes');
    $cardio_seconds = filter_input(INPUT_POST, 'seconds');


//now let's validate

    require_once '../Models/Validation.php';
    $v = new Validation();

    if ($v->testName($cardio_name) == false) {
        $name_error = "Name workout!";
    }
    if ($v->testName($cardio_type == false)){
        $type_error = "Specify type!";
    }
    if ($v->testZero($cardio_distance) == false){
        $distance_error = "Enter goal distance!";
    }
    if ($v->testZero($cardio_hours) == false && $v->testZero($cardio_minutes) == false && $v->testZero($cardio_seconds) == false){
        $time_error = "Enter goal time!!";
    }

    if ($v->testName($cardio_name) == true && $v->testName($cardio_type == true && $v->testZero($cardio_distance) == true && ($v->testZero($cardio_hours) == true || $v->testZero($cardio_minutes) == true || $v->testZero($cardio_seconds) == true))){
        //insert a function to change the time format

        require_once '../functions/time_format_function.php';

        $cardio_time = timeFormat($cardio_hours, $cardio_minutes, $cardio_seconds);
        //now we create a new cardioworkout class and set the values equal to our form values

        require_once '../Models/cardioworkout.php';
        $c = new cardioworkout();

        $c->setName($cardio_name);
        $c->setUserId($user_id);
        $c->setGoalDistance($cardio_distance);
        $c->setGoalTime($cardio_time);
        $c->setUserId($user_id);

        //now let's get the database connection and create a new object

        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();

    //now we grab our DAO object, call the insert method, passing in our db connection and our cardio workout object.

    require_once '../Models/cardioworkoutDAO.php';
    $insert_C = new cardioworkoutDAO();
    $insert_C->insertCardio($conn, $c);
$_SESSION['cardio_success'] = "Cardio workout created!";
header("Location: Cardio.php");

        //set all form values back to zero
      /*  $cardio_name = "";
        $cardio_type = "";
        $cardio_distance = "";
        $cardio_hours =  "";
        $cardio_minutes = "";
        $cardio_seconds = "" ;*/


    }


    }



require_once 'create-cardio-view.php';
?>
