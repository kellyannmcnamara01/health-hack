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

if (isset($_SESSION["workout-type"]) && ($_SESSION["workout-type"] == "strength")) {
    $action = "Strength";
    unset($_SESSION["workout-type"]);
}


if (isset($_POST['backtoindex'])) {
    $redirect_uri .= '/health-hack/FitnessProgress/index.php';
    header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit();
}


if (isset($_POST["sbmStrength"])) {
    $_SESSION["workout-type"] = "strength";
    $redirect_uri .= '/health-hack/FitnessProgress/index.php';
    header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit();
}

include('ViewIndex.php');
?>