<?php
//session_start();
//if (isset($_SESSION["user"])) {
    require_once('../redirect.php');
    require_once('../Models/Database.php');
    require_once('../Models/Gyms.php');
    require_once('../Models/GymLocation.php');
    $db = new Database();
    $db = $db->getDbFromAWS();
    $gymObj = new Gyms();
    $gymObj->setDb($db);

    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'];

    $action = 'Index';
    //$_SESSION['userId'] = 1;

    if (isset($_POST['addGym'])) {
        $action = 'Addgym';
    }

    if ($action == 'Index') {
        include('ViewIndex.php');
    } 
    if ($action == 'Addgym') {
        $redirect_uri .= '/health-hack/Gym/index.php';
        header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    }
/*} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'];
    $redirect_uri .= '/health-hack/landing.php';
    header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}*/
?>