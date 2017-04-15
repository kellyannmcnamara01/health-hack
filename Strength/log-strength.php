<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-27
 * Time: 3:29 PM
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
//grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($id);

//create the db connection
require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDbFromAWS();

//grab all of our strength workouts passing in the connection and strength workout object
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);



//here, a workout has been selected.

if (isset($_POST['load_strength'])){
    $strength_id = filter_input(INPUT_POST,'strength_workout');
    //validate it to make sure it's not zero.

    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testZero($strength_id) == false){
        $strength_workout_error = "You must select a strength workout!";
    }
    else {
        //now create the strength workout object

        $selected_Strength_Workout = new StrengthWorkout();
        $selected_Strength_Workout->setUserId($id);
        $selected_Strength_Workout->setId($strength_id);

        //now let's get all the exercises associated with that strength workout.

        $get_Strength = new StrengthWorkoutDAO();
        $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);



    }
}
if (isset($_POST['save_strength'])) {
    if (!isset($_POST['exercise_id'][0])) {
        $strength_workout_error = "You must select a strength workout!";
    } else {
        //re-capture the form so it still displays if the user presses this button

        //grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

        require_once '../Models/StrengthWorkout.php';
        $sw = new StrengthWorkout();
        $sw->setUserId($id);

//create the db connection
        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();
        $strength_id = filter_input(INPUT_POST, 'strength_workout');
//validate it to make sure it's not zero.

        require_once '../Models/Validation.php';
        $v = new Validation();
        if ($v->testZero($strength_id) == false) {
            $strength_workout_error = "You must select a strength workout!";
        } else {
            //now create the strength workout object

            $selected_Strength_Workout = new StrengthWorkout();
            $selected_Strength_Workout->setUserId($id);
            $selected_Strength_Workout->setId($strength_id);

            //now let's get all the exercises associated with that strength workout.

            $get_Strength = new StrengthWorkoutDAO();
            $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);


//grab all of our strength workouts passing in the connection and strength workout object
            require_once '../Models/StrengthWorkoutDAO.php';
            $get_strength = new StrengthWorkoutDAO();
            $strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);

            $completed_exercise_id = array($_POST['exercise_id'])[0];
            $completed_strength_id = array($_POST['strength_id'])[0];
            $exercise_name = array($_POST['exercise_name'])[0];
            $weight = array($_POST['weight'])[0];
            $set_1 = array($_POST['set_1'])[0];
            $set_2 = array($_POST['set_2'])[0];
            $set_3 = array($_POST['set_3'])[0];
            // must evaluate for a value of 0 within weight and set 1. Our users are allowed to do only 1 set of an exercise so we only have to make sure the first set is not 0
            //we will do this by searching the array for 0

            if (in_array(0, $weight) || in_array(0, $set_1)) {
                if (in_array(0, $set_1)) {
                    $set_1_error = "You must provide a value for at least the first set.";
                }
                if (in_array(0, $weight)) {
                    $weight_error = "You must enter a weight!";
                }
            } else {

                //now that we've grabbed all the elements we need, we must insert them into the completed strength workouts table in a foreach loop

                for ($i = 0; $i < count($completed_exercise_id); $i++) {
                    //if the value is no weight (in the case of weightless exercises like pull ups
                    //we switch the value back to 0 to insert into db. We must do it this way because
                    //the alternative is to allow for 0 values in the select box, which would not validate for users
                    //forgetting to enter a weight. So at the bottom of the weight select box, we provide a value that is
                    //"No weight."
                    if ($weight[$i] == "1") {
                        $weight[$i] = 0;
                    }
                    $query = "INSERT INTO COMPLETED_STRENGTH_EXERCISES 
        (exercise_id, strength_id, exercise_name, weight, set_1, set_2, set_3)
        VALUES (:completed_exercise_id, :completed_strength_id, :exercise_name, :weight,:set_1, :set_2, :set_3 )";
                    $statement = $conn->prepare($query);
                    $statement->bindValue(':completed_exercise_id', $completed_exercise_id[$i]);
                    $statement->bindValue(':completed_strength_id', $completed_strength_id[$i]);
                    $statement->bindValue('exercise_name', $exercise_name[$i]);
                    $statement->bindValue(':weight', $weight[$i]);
                    $statement->bindValue(':set_1', $set_1[$i]);
                    $statement->bindValue(':set_2', $set_2[$i]);
                    $statement->bindValue(':set_3', $set_3[$i]);
                    $statement->execute();
                    $statement->closeCursor();
                    $log_success = "Workout logged!";
                    //$_SESSION['strength_success'] = "Workout saved. Nice work!";
                    $expire = time() + 1;
                    setcookie('success', 'Workout logged!', $expire, '/');
                    header("Location: strength.php");

                }
            }

        }
    }
}
require_once 'log-strength-view.php';
?>
