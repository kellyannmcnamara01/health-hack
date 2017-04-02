<?php
require('../Models/Database.php');
require('../Models/Gyms.php');
require('../Models/GymLocation.php');
$db = new Database();
$db = $db->getDbFromAWS();
$gymObj = new Gyms();
$gymObj->setDb($db);

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'];

$action = 'Index';
$_SESSION['userId'] = 1;

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
?>