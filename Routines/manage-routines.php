<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:47 PM
 */
require_once '../redirect.php';


require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDbFromAWS();
if (isset($_POST['set_active'])){
    //change the row that is active to 'no'
    $routine_id = filter_input(INPUT_POST, 'routine');
    require_once '../Models/Routine.php';
    $routine_Change = new Routine();
    $routine_Change->setRoutineId($routine_id);
    $routine_Change->setUserId($id);

    require_once '../Models/RoutineDAO.php';
    $r_Change = new RoutineDAO();
    $r_Change->setInactive($conn, $routine_Change);
    //update the row with the id we have now and set it to active = 'yes'

    $r_Change->setActive($conn, $routine_Change);
    $expire = time() +1;
    setcookie('success', 'Routine set!', $expire, '/');
    header("Location: routines.php");
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
            $routine_Delete->setUserId($id);

            $r_Delete = new RoutineDAO();
            $r_Delete->deleteRoutine($conn, $routine_Delete);
            $expire = time() + 1;
            setcookie('success', 'Routine(s) deleted', $expire, '/');
            header("Location: routines.php");
        }
    }

}


//get routines where the user id is equal to our user
require_once '../Models/RoutineDAO.php';
require_once '../Models/Routine.php';
$our_User = new Routine();
$our_User->setUserId($id);
$r = new RoutineDAO();
$routines = $r->getRoutines($conn, $our_User);




require_once 'manage-routines-view.php';