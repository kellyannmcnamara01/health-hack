<?php
require('../Models/Database.php');
require('../Models/FitnessProgress.php');
$db = new Database();
$db = $db->getDbWithPass("ivan95");

$fitnessProg = new FitnessProgress();
$fitnessProg->setDb($db);

$action = 'Index';

if ($action == 'Index') {
    include('ViewIndex.php');
}
?>