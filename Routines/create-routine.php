<?php
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
//create a new $cardioworkout object and set it's user id equal to that of the user logged in.

require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($id);


//grab the database connection.

require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

//grabbing strength workouts

//grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($id);

//grab all of our strength workouts passing in the connection and strength workout object
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);


if (isset($_POST['routine_yes']) || isset($_POST['routine_no'])) {

        //setting up a flag variable here for validation later. If any of our
        //validation fails, this will be set to false and submission to db will not occur.
    $valid = true;

    //grab all the data, and run a function that converts values of zero to null.

    require_once '../functions/convert_to_null.php';
        $routine_name = filter_input(INPUT_POST, 'routine_name');
        $monday_cardio = filter_input(INPUT_POST, 'monday_cardio');
        $monday_cardio = convertToNull($monday_cardio);
        $monday_cardio = convertToNull($monday_cardio);
        $monday_strength = filter_input(INPUT_POST, 'monday_strength');
        $monday_strength = convertToNull($monday_strength);
        $tuesday_cardio = filter_input(INPUT_POST, 'tuesday_cardio');
        $tuesday_cardio = convertToNull($tuesday_cardio);
        $tuesday_strength = filter_input(INPUT_POST, 'tuesday_strength');
        $tuesday_strength = convertToNull($tuesday_strength);
        $wednesday_cardio = filter_input(INPUT_POST, 'wednesday_cardio');
        $wednesday_cardio = convertToNull($wednesday_cardio);
        $wednesday_strength = filter_input(INPUT_POST, 'wednesday_strength');
        $wednesday_strength = convertToNull($wednesday_strength);
        $thursday_cardio = filter_input(INPUT_POST, 'thursday_cardio');
        $thursday_cardio = convertToNull($thursday_cardio);
        $thursday_strength = filter_input(INPUT_POST, 'thursday_strength');
        $thursday_strength = convertToNull($thursday_strength);
        $friday_cardio = filter_input(INPUT_POST, 'friday_cardio');
        $friday_cardio = convertToNull($friday_cardio);
        $friday_strength = filter_input(INPUT_POST, 'friday_strength');
        $friday_strength = convertToNull($friday_strength);
        $saturday_cardio = filter_input(INPUT_POST, 'saturday_cardio');
        $saturday_cardio = convertToNull($saturday_cardio);
        $saturday_strength = filter_input(INPUT_POST, 'saturday_strength');
        $saturday_strength = convertToNull($saturday_strength);
        $sunday_cardio = filter_input(INPUT_POST, 'sunday_cardio');
        $sunday_cardio = convertToNull($sunday_cardio);
        $sunday_strength = filter_input(INPUT_POST, 'sunday_strength');
        $sunday_strength = convertToNull($sunday_strength);

            //validation for empty
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($routine_name) == false){
        $routine_name_error = "You must provide a name for the routine";
        $valid = false;
    }
    //create a new routine object
    require_once '../Models/Routine.php';
    $r = new Routine();

    //create a routine DAO object and use it to insert into db
    require_once '../Models/Routine.php';
    $r = new Routine();
    $r->setName($routine_name);
    $r->setUserId($id);

    //now let's create a new workout routine dao, pass in our routine in the getRoutines function to make sure we
    //our user names their new routine uniquely.
    require_once '../Models/RoutineDAO.php';
    $unique_Name_Check = new RoutineDAO();
    $list = $unique_Name_Check->verifyUniqueName($conn, $r);
    $routine_Names_List = array();
    foreach ($list as $key => $value) {
        array_push($routine_Names_List, $value[0]);
    }
    if (in_array($routine_name, $routine_Names_List)) {
        $routine_name_error = "You must pick a unique workout name!";
        $valid = false;
    }

    if ($monday_strength == null && $tuesday_strength == null && $wednesday_strength == null && $thursday_strength == null && $friday_strength == null &&
        $saturday_strength == null && $sunday_strength == null && $monday_cardio == null && $tuesday_cardio == null && $wednesday_cardio == null && $thursday_cardio == null && $friday_cardio == null && $saturday_cardio == null && $sunday_cardio == null){
        $workout_error = "You forgot to enter workouts!";
        $valid = false;
    }

if ($valid) {



//set the cardio workouts
        $r->setMondayCardio($monday_cardio);
        $r->setTuesdayCardio($tuesday_cardio);
        $r->setWednesdayCardio($wednesday_cardio);
        $r->setThursdayCardio($thursday_cardio);
        $r->setFridayCardio($friday_cardio);
        $r->setSaturdayCardio($saturday_cardio);
        $r->setSundayCardio($sunday_cardio);

//set the strength workouts
        $r->setMondayStrength($monday_strength);
        $r->setTuesdayStrength($tuesday_strength);
        $r->setWednesdayStrength($wednesday_strength);
        $r->setThursdayStrength($thursday_strength);
        $r->setFridayStrength($friday_strength);
        $r->setSaturdayStrength($saturday_strength);
        $r->setSundayStrength($sunday_strength);

//two different possibilities depending on if they want to make the routine the active routine in their calendar.

        //if they do want to make the routine active in the calendar
        if (isset($_POST['routine_yes'])) {
            $activeValue = "Yes";
            $r->setActive($activeValue);
            $rou_yes = new RoutineDAO();
            //run query to set all rows (should only be 1) that are set to active to inactive
            $rou_yes->setInactive($conn, $r);
            $rou_yes->insertRoutine($conn, $r);
            $expire = time() + 1;
            setcookie('success', 'Routine set!', $expire, '/');
            header("Location: routines.php");

        }

        //if they don't want to make it active in the calendar.
        if (isset($_POST['routine_no'])) {
            $activeValue = "No";
            $r->setActive($activeValue);
            $rou_no = new RoutineDAO();
            $rou_no->insertRoutine($conn, $r);
            $expire = time() + 1;
            setcookie('success', 'Routine created!', $expire, '/');
            header("Location: routines.php");

        }
    }

}

require_once 'create-routine-view.php';