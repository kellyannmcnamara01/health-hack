<?php
require('../Models/Database.php');
require('../Models/Calendar.php');
$db = new Database();
$db = $db->getDbWithPass("ivan95");
$calendar = new Calendar(date('m'), date('Y'));
$calendar->setDb($db);

$action = 'Index';

if ($action == 'Index') {
    include('ViewIndex.php');
}
?>