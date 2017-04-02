<?php
require('../Models/Database.php');
require('../Models/Gyms.php');
require('../Models/GymLocation.php');
$db = new Database();
$db = $db->getDbFromAWS();
$gymObj = new Gyms();
$gymObj->setDb($db);

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$_SESSION['userId'] = 1;

$action = 'Index';

if (isset($_POST['addGym'])) {
    $gymInfo = new GymLocation($_POST);
    $addedGym = $gymObj->addGymToFav($gymInfo);
    header("Location: " . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

include('ViewIndex.php');
?>