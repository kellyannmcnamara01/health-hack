<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:47 PM
 */
require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDbFromAWS();
$user_id = 1;
if (isset($_POST['set_active'])){
    //change the row that is active to 'no'
    $routine_id = filter_input(INPUT_POST, 'routine');
    require_once '../Models/Routine.php';
    $routine_Change = new Routine();
    $routine_Change->setRoutineId($routine_id);
    $routine_Change->setUserId($user_id);

    require_once '../Models/RoutineDAO.php';
    $r_Change = new RoutineDAO();
    $r_Change->setInactive($conn, $routine_Change);
    //update the row with the id we have now and set it to active = 'yes'

    $r_Change->setActive($conn, $routine_Change);
    $success_message = "Active routine changed!";
}
if (isset($_POST['delete_routines'])) {
    require_once '../Models/Routine.php';
    require_once '../Models/RoutineDAO.php';

    if (empty($_POST['routine_check'])) {
        $delete_error = "You must select a routine to delete.";

    } //filter input doesn't work here.
    else {
        $routine_delete = $_POST ['routine_check'];
        foreach ($routine_delete as $key => $value) {
            //set a new routine object, then reference it in the delete DAO method.

            $routine_Delete = new Routine();
            $routine_Delete->setRoutineId($value);
            $routine_Delete->setUserId($user_id);

            $r_Delete = new RoutineDAO();
            $r_Delete->deleteRoutine($conn, $routine_Delete);
            $success_message = "Routine deleted!";
        }
    }

}


//get routines where the user id is equal to our user
require_once '../Models/RoutineDAO.php';
require_once '../Models/Routine.php';
$our_User = new Routine();
$our_User->setUserId($user_id);
$r = new RoutineDAO();
$routines = $r->getRoutines($conn, $our_User);




require_once 'manage-routines-view.php';