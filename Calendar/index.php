<?php
require('../Models/Database.php');
require('../Models/Calendar.php');
$db = new Database();
$db = $db->getDbWithPass("ivan95");
date_default_timezone_set('America/Toronto');
$calendar = new Calendar(date('m'), date('Y'));
$calendar->setDb($db);

$action = 'Index';

if ($action == 'Index') {
    include('ViewIndex.php');
}
?>