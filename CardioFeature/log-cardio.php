<?php
ob_start();
require_once '../redirect.php';
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

//now, if the load button is clicked, we have to load that specific cardio workout and it's details.

if (isset($_POST['load_cardio'])) {
    //grab our id of the cardio workout that was selected from the drop-down menu

    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');
    //now assign this value to a new cardio workout object

    if ($cardio_id == "0") {
        $cardio_workout_error = "You must select a cardio workout to log.";
    } else {
        $selected_Cardio_Workout = new cardioworkout();
        $selected_Cardio_Workout->setUserId($id);
        $selected_Cardio_Workout->setId($cardio_id);

        //running a query to get all of the information for the cardio workout that was selected.
        $get_1_Cardio = new cardioworkoutDAO();
        $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);
    }
}
if (isset($_POST['save_workout'])) {

    //re-capture the form input so it still displays if the user clicks this button.
    //we also do this in case the user submits the workout without first loading workout details, which is acceptable.
    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');
    //now assign this value to a new cardio workout object

    $selected_Cardio_Workout = new cardioworkout();
    $selected_Cardio_Workout->setUserId($id);
    $selected_Cardio_Workout->setId($cardio_id);

    //running a query to get all of the information for the cardio workout that was selected.
    $get_1_Cardio = new cardioworkoutDAO();
    $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);

    //grab our values to be inserted into completed cardio workouts.
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');

    //do validation.
    require_once '../Models/Validation.php';
    $v = new Validation();

    if ($cardio_id == 0) {
        $cardio_workout_error = "Select a workout!";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance!";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time!";
    }
    //testing if everything validates to true, and if so, do the steps required to insert into the database.
    if ($cardio_id != 0 && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //grab our function file to format the time
        require_once '../functions/time_format_function.php';
        $cardio_time = timeFormat($hours, $minutes, $seconds);

        //now create a new completed cardio workout object.
        require_once '../Models/completedCardioWorkout.php';
        $completed_Cardio = new completedCardioWorkout();

        //set the properties of this completed cardio workout equal to the form values.
        $completed_Cardio->setCardioId($cardio_id);
        $completed_Cardio->setDistance($distance);
        $completed_Cardio->setTime($cardio_time);

        //create a new DAO object, and call the method to insert, passing in our connection and completed cardio object

        $complete = new cardioworkoutDAO();
        $complete->insertCompletedCardio($conn, $completed_Cardio);

        //set all form values back to zero.
        $distance = 0;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        $expire = time() + 1;
        setcookie('success', 'Cardio workout logged!', $expire, '/');
        header("Location: Cardio.php");

    }
}
require_once 'log-cardio-view.php';
?>
