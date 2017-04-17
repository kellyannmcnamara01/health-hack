<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 6:13 PM
 */
//grab the database connection.
ob_start();
require_once '../redirect.php';


require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

if (isset($_POST['delete_cardio'])){
    require_once '../Models/completedCardioWorkout.php';
    require_once '../Models/cardioworkout.php';
    require_once '../Models/cardioworkoutDAO.php';
    require_once '../Models/RoutineDAO.php';

    if (empty($_POST['cardio_check'])) {
        $delete_error = "You must select a routine to delete.";

    } //filter input doesn't work here.
    else {

            $cardio_delete = $_POST ['cardio_check'];
            foreach ($cardio_delete as $key => $value) {
                //set a new routine object, then reference it in the delete DAO method.

                //must delete the child/foreign key references first

                //first we delete from completed cardio workouts
                $completed_Cardio_Delete = new completedCardioWorkout();
                $completed_Cardio_Delete->setCardioId($value);

                $c_Cardio_Delete = new cardioworkoutDAO();
                $c_Cardio_Delete->deleteCompletedCardio($conn, $completed_Cardio_Delete);

                //then we delete from the routines table
                $r_Cardio = new RoutineDAO();
                $r_Cardio->deleteCardioRoutine($conn, $value);


                //then we delete the parent keys.
                $cardio_Delete = new cardioworkout();
                $cardio_Delete->setId($value);
                $cardio_Delete->setUserId($id);


                $c_Delete = new cardioworkoutDAO();
                $c_Delete->deleteCardio($conn, $cardio_Delete);
                $expire = time() + 1;
                setcookie('success', 'Cardio workout(s) deleted!', $expire, '/');
                header("Location: Cardio.php");

        }

        }




}

require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($id);
//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

require_once 'manage-cardio-workouts-view.php';
?>