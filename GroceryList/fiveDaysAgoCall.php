<?php

require_once "../Models/Database.php";
//require_once "statistics.php";


$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();

$fiveDaysAgo = $gListConn->populateFiveDaysAgo($db);

$fiveDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($fiveDaysAgo as $entry) {
    $fiveDaysArr['calories'] += $entry->calories;
    $fiveDaysArr['fat'] += $entry->fat;
    $fiveDaysArr['cholesterol'] += $entry->cholesterol;
    $fiveDaysArr['sodium'] += $entry->sodium;
    $fiveDaysArr['carbs'] += $entry->carbs;
    $fiveDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($fiveDaysArr);

header("Content-Type: application/json");
echo $jcat;



?>
