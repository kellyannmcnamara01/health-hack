<?php
ob_start();
require_once '../redirect.php';

if (isset($_POST['submit_cardio'])){

    //set up a flag variable that gets turned to false if any of our validation fails
    $cardio_Valid = true;
    //grab inputs from previous form

    $cardio_name = filter_input(INPUT_POST, 'cardio_name');
    $cardio_type = filter_input(INPUT_POST, 'cardio_type');
    $cardio_distance = filter_input(INPUT_POST, 'cardio_distance');
    $cardio_hours =  filter_input(INPUT_POST, 'hours');
    $cardio_minutes = filter_input(INPUT_POST, 'minutes');
    $cardio_seconds = filter_input(INPUT_POST, 'seconds');


//now let's validate

    //now let's get the database connection and create a new object

    require_once '../Models/Database.php';
    $db = new Database();
    $conn = $db->getDbFromAWS();

    require_once '../Models/Validation.php';
    require_once '../Models/cardioworkout.php';
    $c = new cardioworkout();

    $c->setUserId($id);

    require_once '../Models/cardioworkoutDAO.php';
    $insert_C = new cardioworkoutDAO();

    $list = $insert_C->verify_Unique_Cardio($conn, $c);
    $cardio_Names_List = array();
    foreach ($list as $key => $value){
        array_push($cardio_Names_List, $value[0]);
    }
    if (in_array($cardio_name, $cardio_Names_List)){
        $name_error = "You must pick a unique name!";
        $cardio_Valid = false;
    }

    $v = new Validation();

    if ($v->testName($cardio_name) == false) {
        $name_error = "Name workout!";
        $cardio_Valid = false;

    }
    if ($v->testName($cardio_type == false)){
        $type_error = "Specify type!";
        $cardio_Valid = false;

    }
    if ($v->testZero($cardio_distance) == false){
        $distance_error = "Enter goal distance!";
        $cardio_Valid = false;

    }
    if ($v->testZero($cardio_hours) == false && $v->testZero($cardio_minutes) == false && $v->testZero($cardio_seconds) == false){
        $time_error = "Enter goal time!!";
        $cardio_Valid = false;

    }

if ($cardio_Valid){        //insert a function to change the time format

        require_once '../functions/time_format_function.php';

        $cardio_time = timeFormat($cardio_hours, $cardio_minutes, $cardio_seconds);
        //now we create a new cardioworkout class and set the values equal to our form values

        require_once '../Models/cardioworkout.php';
        $c = new cardioworkout();

        $c->setName($cardio_name);
        $c->setUserId($id);
        $c->setGoalDistance($cardio_distance);
        $c->setGoalTime($cardio_time);
        $c->setUserId($id);


    //now we grab our DAO object, call the insert method, passing in our db connection and our cardio workout object.


    $insert_C->insertCardio($conn, $c);
$expire = time() + 1;
setcookie('success', 'Cardio workout created!', $expire, '/');
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
