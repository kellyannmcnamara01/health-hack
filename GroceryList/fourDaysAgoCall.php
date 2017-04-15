<?php

require_once "../Models/Database.php";
//require_once "statistics.php";


$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();

$fourDaysAgo = $gListConn->populateFourDaysAgo($db);

$fourDaysArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

foreach ($fourDaysAgo as $entry) {
    $fourDaysArr['calories'] += $entry->calories;
    $fourDaysArr['fat'] += $entry->fat;
    $fourDaysArr['cholesterol'] += $entry->cholesterol;
    $fourDaysArr['sodium'] += $entry->sodium;
    $fourDaysArr['carbs'] += $entry->carbs;
    $fourDaysArr['protein'] += $entry->protein;
}

$jcat = json_encode($fourDaysArr);

header("Content-Type: application/json");
echo $jcat;



?>
