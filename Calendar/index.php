<?php
require('../Models/Database.php');
require('../Models/Calendar.php');
date_default_timezone_set('America/Toronto');

$db = new Database();
$db = $db->getDbFromAWS();
session_start();
$_SESSION["user"] = 1;

$calendar = new Calendar(date('m'), date('Y'), $_SESSION["user"]);
$calendar->setDb($db);

$action = 'Index';

if ($action == 'Index') {
    include('ViewIndex.php');
}
?>