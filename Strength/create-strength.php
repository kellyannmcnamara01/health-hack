<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 4:32 PM
 */
ob_start();
session_start();

$user_id = 1;

if (isset($_POST['submit_strength'])){

    //get the values
    $strength_name = filter_input(INPUT_POST,'strength_name');

    if (!isset($_POST['exercises'])) {
        $exercise_error = "You must enter exercises for the workout!";
    }
    else {
        $exercises = array($_POST['exercises']);
        $string = $exercises[0];
    }


    //validate the strength name

    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($strength_name) == false){
    $strength_error = "Provide a name for this workout!";
    }

    //if a workout name has been provided, and exercises for the workout have been provided, insert into the database.
    if ($v->testName($strength_name) == true && isset($_POST['exercises'])) {
        //create a connection
        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();

        //create a new strength workout class and set its values.

        require_once '../Models/StrengthWorkout.php';
        $strength_workout = new StrengthWorkout();
        $strength_workout->setUserId($user_id);
        $strength_workout->setName($strength_name);

        //check if there is another strength workout that has the same name. If there is, provide an error message and do not proceed.
        require_once '../Models/StrengthWorkoutDAO.php';
        $sw = new StrengthWorkoutDAO();
        $list = $sw->verifyUniqueName($conn, $strength_workout);
        $namesList = array();
        foreach ($list as $key=>$value){
            array_push($namesList, $value[0]);
        }
        if (in_array($strength_name, $namesList)){
            $strength_error = "You must pick a unique workout name!";
        }
        else {

            //create a new strengthDAO class and insert into the database.
            require_once '../Models/StrengthWorkoutDAO.php';
            $sw = new StrengthWorkoutDAO();
            $sw->insertStrengthWorkout($conn, $strength_workout);


            //now, let's add the exercises that were stored in our list.

            foreach ($string as $key => $value) {
                $sw->insertStrengthExercises($conn, $value, $strength_workout);
            }
            $success_message = "Workout created!";
            $strength_name = "";
            $_SESSION['strength_success'] = "Workout created!";
            header("Location: strength.php");
        }
    }
}
require_once 'create-strength-view.php';
?>

