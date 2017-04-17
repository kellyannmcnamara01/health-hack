<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-08
 * Time: 4:28 PM
 */
ob_start();
require_once '../redirect.php';
require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

if (isset($_POST['delete_strength'])){
    require_once '../Models/Exercises.php';
    require_once '../Models/StrengthWorkout.php';
    require_once '../Models/StrengthWorkoutDAO.php';
    require_once '../Models/RoutineDAO.php';

    if (empty($_POST['strength_check'])) {
        $delete_error = "You must select a strength workout to delete.";

    } //filter input doesn't work here.
    else {

        $strength_delete = $_POST ['strength_check'];
        foreach ($strength_delete as $key => $value) {
            //set a new routine object, then reference it in the delete DAO method.

            //must delete the child/foreign key references first

            //first we delete from completed strength workouts
           $query = "DELETE FROM COMPLETED_STRENGTH_EXERCISES WHERE strength_id = :strength_id";
           $statement = $conn->prepare($query);
           $statement->bindValue(':strength_id', $value);
           $statement->execute();
           $statement->closeCursor();


            //then we delete from the exercises table
            $exercises = new Exercises();
            $exercises->setStrengthWorkoutId($value);

            $e = new StrengthWorkoutDAO();
            $e->deleteStrengthExercises($conn, $exercises);


            //then we delete from the routines table
            $r_Strength = new RoutineDAO();
            $r_Strength->deleteStrengthRoutine($conn, $value);


            //then we delete the parent keys.
            $strength_Delete = new StrengthWorkout();
            $strength_Delete->setId($value);
            $strength_Delete->setUserId($id);


            $s_Delete = new StrengthWorkoutDAO();
            $s_Delete->deleteStrengthWorkout($conn, $strength_Delete);
            $expire = time() + 1;
            setcookie('success', 'Workout(s) deleted!', $expire, '/');
            header("Location: strength.php");
            header("Location: strength.php");
        }

    }




}

require_once '../Models/StrengthWorkout.php';
$s = new StrengthWorkout();
$s->setUserId($id);//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/StrengthWorkoutDAO.php';
$get_Strength      = new StrengthWorkoutDAO();
$strength_workouts = $get_Strength->getStrengthWorkouts($conn, $s);

require_once 'manage-strength-workouts-view.php';
?>