<?php

require_once "../Models/Database.php";
//require_once "statistics.php";


$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();

$todaysEntries = $gListConn->populateTodaysFoodEntries($db);

$todayArr = ['calories' => 0, 'fat' => 0, 'cholesterol' => 0, 'sodium' => 0, 'carbs' => 0, 'protein' => 0];

//var_dump($todaysEntries[2]->fat);

foreach ($todaysEntries as $today) {
    $todayArr['calories'] += $today->calories;
    $todayArr['fat'] += $today->fat;
    $todayArr['cholesterol'] += $today->cholesterol;
    $todayArr['sodium'] += $today->sodium;
    $todayArr['carbs'] += $today->carbs;
    $todayArr['protein'] += $today->protein;
}

$jcat = json_encode($todayArr);

header("Content-Type: application/json");
return $jcat;



?>