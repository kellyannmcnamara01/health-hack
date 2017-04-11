<?php
require('../Models/Database.php');
require('../Models/FitnessProgress.php');
$db = new Database();
$db = $db->getDbFromAWS();

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'];

$fitnessProg = new FitnessProgress();
$fitnessProg->setDb($db);

session_start();

$_SESSION["user"] = 1;

$action = 'Index';

if (isset($_POST["sbmStrength"])) {
    $_SESSION["workout-type"] = "strength";
    //$redirect_uri .= '/health-hack/FitnessProgress/index.php';
    //header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    $action = 'Strength';
}

include('ViewIndex.php');
?>