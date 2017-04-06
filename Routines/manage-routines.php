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

if (isset($_POST['set_active'])){
    //change the row that is active to 'no'
    $routine_id = filter_input(INPUT_POST, 'routine');
    require_once '../Models/Routine.php';
    $routine_Change = new Routine();
    $routine_Change->setRoutineId($routine_id);

    require_once '../Models/RoutineDAO.php';
    $r_Change = new RoutineDAO();
    $r_Change->setInactive($conn);
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

            $r_Delete = new RoutineDAO();
            $r_Delete->deleteRoutine($conn, $routine_Delete);
            $success_message = "Routine deleted!";
        }
    }

}


//get routines
require_once '../Models/RoutineDAO.php';
$r = new RoutineDAO();
$routines = $r->getRoutines($conn);




require_once 'manage-routines-view.php';