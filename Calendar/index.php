<?php
//session_start();
//if (isset($_SESSION["user"])) {
    require_once('../redirect.php');
    require_once('../Models/Database.php');
    require_once('../Models/Calendar.php');
    date_default_timezone_set('America/Toronto');

    $db = new Database();
    $db = $db->getDbFromAWS();
    //session_start();
    //$_SESSION["user"] = 1;

    $calendar = new Calendar(date('m'), date('Y'), $_SESSION["user"]);
    $calendar->setDb($db);

    $action = 'Index';

    if ($action == 'Index') {
        include('ViewIndex.php');
    }
/*} else {
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'];
    $redirect_uri .= '/health-hack/landing.php';
    header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}*/
?>