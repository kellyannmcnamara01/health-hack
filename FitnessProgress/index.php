<?php
require('../Models/Database.php');
$db = new Database();
$db = $db->getDbWithPass("ivan95");

$action = 'Index';

if ($action == 'Index') {
    include('ViewIndex.php');
}
?>