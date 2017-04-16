<?php

$user_id = 1;
$list_id = 5;

//db
require_once "../Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();
$gLists = $gListConn->populateGroceryLists($db);
$userList = $gListConn->populateUserListId($db);
$todaysEntries = $gListConn->populateTodaysFoodEntries($db);
$weeksEntries = $gListConn->populateWeeksFoodEntries($db);
$sixDaysAgo = $gListConn->populateSixDaysAgo($db);
$fiveDaysAgo = $gListConn->populateFiveDaysAgo($db);
$fourDaysAgo = $gListConn->populateFourDaysAgo($db);
$threeDaysAgo = $gListConn->populateThreeDaysAgo($db);
$twoDaysAgo = $gListConn->populateSixDaysAgo($db);
$todaysBreakfast = $gListConn->populateTodaysBreakfast($db);
$todaysLunch = $gListConn->populateTodaysLunch($db);
$todaysDinner = $gListConn->populateTodaysDinner($db);
$todaysSnacks = $gListConn->populateTodaysSnacks($db);

if($list_id == 0){
    header('Location: ../GroceryList/Grocery.php');
} elseif($list_id == 5) {
    $list = $gListConn->populateVeggieList($db);
} elseif ($list_id == 6) {
    $list = $gListConn->populateAtkinsList($db);
} else {
    $list = $gListConn->populateGlutenFreeList($db);
}

//include the header
require_once "../Common Views/Header.php";

//include the sidebar
require_once "../Common Views/sidebar.php";

//empty vars prior to submit
$food_item_id = "";
$meal = "";
$servings_count = "";
$timestamp = "";
$cals_total = "";

$totalCalsB = "";
$totalCalsL = "";
$totalCalsD = "";
$totalCalsS = "";

////////
/*$totalCals = ""; $totalFat = ""; $totalCholesterol = ""; $totalSodium = ""; $totalCarbs = ""; $totalProtein = "";
$totalWeekCals = ""; $totalWeekFat = ""; $totalWeekCholesterol = ""; $totalWeekSodium = ""; $totalWeekCarbs = ""; $totalWeekProtein = "";
$totalSixDaysCals = ""; $totalSixDaysFat = ""; $totalSixDaysCholesterol = ""; $totalSixDaysSodium = ""; $totalSixDaysCarbs = ""; $totalSixDaysProtein = "";
$totalFiveDaysCals = ""; $totalFiveDaysFat = ""; $totalFiveDaysCholesterol = ""; $totalFiveDaysSodium = ""; $totalFiveDaysCarbs = ""; $totalFiveDaysProtein = "";
$totalFourDaysCals = ""; $totalFourDaysFat = ""; $totalFourDaysCholesterol = ""; $totalFourDaysSodium = ""; $totalFourDaysCarbs = ""; $totalFourDaysProtein = "";
$totalThreeDaysCals = ""; $totalThreeDaysFat = ""; $totalThreeDaysCholesterol = ""; $totalThreeDaysSodium = ""; $totalThreeDaysCarbs = ""; $totalThreeDaysProtein = "";
$totalTwoDaysCals = ""; $totalTwoDaysFat = ""; $totalTwoDaysCholesterol = ""; $totalTwoDaysSodium = ""; $totalTwoDaysCarbs = ""; $totalTwoDaysProtein = "";
*/



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

$fatDV = round(($todayArr['fat'] / 65) * 100);
$cholesterolDV = round(($todayArr['cholesterol'] / 300) * 100);
$sodiumDV = round(($todayArr['sodium'] / 2400) * 100);
$carbsDV = round(($todayArr['carbs'] / 300) * 100);



/*
foreach ($sixDaysAgo as $entry) {
    $totalSixDaysCals += $entry->calories;
    $totalSixDaysFat += $entry->fat;
    $totalSixDaysCholesterol += $entry->cholesterol;
    $totalSixDaysSodium += $entry->sodium;
    $totalSixDaysCarbs += $entry->carbs;
    $totalSixDaysProtein += $entry->protein;
}
foreach ($fiveDaysAgo as $entry) {
    $totalFiveDaysCals += $entry->calories;
    $totalFiveDaysFat += $entry->fat;
    $totalFiveDaysCholesterol += $entry->cholesterol;
    $totalFiveDaysSodium += $entry->sodium;
    $totalFiveDaysCarbs += $entry->carbs;
    $totalFiveDaysProtein += $entry->protein;
}
foreach ($fourDaysAgo as $entry) {
    $totalFourDaysCals += $entry->calories;
    $totalFourDaysFat += $entry->fat;
    $totalFourDaysCholesterol += $entry->cholesterol;
    $totalFourDaysSodium += $entry->sodium;
    $totalFourDaysCarbs += $entry->carbs;
    $totalFourDaysProtein += $entry->protein;
}
foreach ($threeDaysAgo as $entry) {
    $totalThreeDaysCals += $entry->calories;
    $totalThreeDaysFat += $entry->fat;
    $totalThreeDaysCholesterol += $entry->cholesterol;
    $totalThreeDaysSodium += $entry->sodium;
    $totalThreeDaysCarbs += $entry->carbs;
    $totalThreeDaysProtein += $entry->protein;
}
foreach ($twoDaysAgo as $entry) {
    $totalTwoDaysCals += $entry->calories;
    $totalTwoDaysFat += $entry->fat;
    $totalTwoDaysCholesterol += $entry->cholesterol;
    $totalTwoDaysSodium += $entry->sodium;
    $totalTwoDaysCarbs += $entry->carbs;
    $totalTwoDaysProtein += $entry->protein;
}*/


if(isset($_POST['foodEntrySubmit'])) {

    //include the getter and setter for the food entry file
    require_once "../Models/FoodEntry.php";

    //set the vars
    $food_item_id = $_POST["food-item-selected"];
    $meal = $_POST["meal"];
    $servings_count = $_POST["severing"];
    //$time = new DateTime();
    //$timestamp = $time->format('Y-m-d H:i:s');
    $timestamp = date("Y-m-d");
    $user_id = 1;

    //setting the values
    $foodEntryGetSet = new FoodEntry();
    $foodEntryGetSet->setFoodItemId($food_item_id);
    $foodEntryGetSet->setMeal($meal);
    $foodEntryGetSet->setServingsCount($servings_count);
    $foodEntryGetSet->setTimestamp($timestamp);
    $foodEntryGetSet->setUserId($user_id);

    //var_dump($foodEntryGetSet->getUserId());
    $gListConn->userFoodEntry($db, $foodEntryGetSet);


}

?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">

    <div class="col-md-12 row">
        <div class="col-md-4">
            <h4 class="text-center padding-top-75">Comparative Daily Nutrition Intake</h4>
            <canvas id="nutritionChart"></canvas>
        </div>
        <div class="col-md-4">
            <h4 class="text-center padding-top-75">Comparative Weekly Nutrition Intake</h4>
            <canvas id="weeklyNutritionChart"></canvas>
        </div>
    </div>
    <!------>
    <div class="col-md-10">
        <h4 class="text-center padding-top-75">Weekly Results</h4>
        <canvas id="weekResults"></canvas>
    </div>
    <!------>
    <div class="col-md-10">
        <div class="col-md-12 col-sm-12 col-12 row">
            <h4 class="col-md-12 col-sm-12 col-12 padding-top-75">Today's DV% Intakes</h4>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Fat DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $fatDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $fatDV ?>%;">
                        <?php echo $fatDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Cholesterol DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $cholesterolDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cholesterolDV ?>%;">
                        <?php echo $cholesterolDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Sodium DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $sodiumDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $sodiumDV ?>%;">
                        <?php echo $sodiumDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Carbs DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $carbsDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $carbsDV ?>%;">
                        <?php echo $carbsDV ?>%
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-12 row">
            <h4 class="col-md-12 col-sm-12 col-12">Today's DV% Intakes</h4>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Fat DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $fatDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $fatDV ?>%;">
                        <?php echo $fatDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Cholesterol DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $cholesterolDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $cholesterolDV ?>%;">
                        <?php echo $cholesterolDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Sodium DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $sodiumDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $sodiumDV ?>%;">
                        <?php echo $sodiumDV ?>%
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-8">
                <h2 class="text-center">Carbs DV% Intake Total</h2>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $carbsDV ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $carbsDV ?>%;">
                        <?php echo $carbsDV ?>%
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--hidden div containing all of the number output-->
    <div style="display: none">
        <!--<div id="totalCals"><?php echo $totalCals ?></div>
        <div id="totalFat"><?php echo $totalFat ?></div>
        <div id="totalCholesterol"><?php echo $totalCholesterol ?></div>
        <div id="totalSodium"><?php echo $totalSodium ?></div>
        <div id="totalCarbs"><?php echo $totalCarbs ?></div>
        <div id="totalProtein"><?php echo $totalProtein ?></div>
        <div id="fatDV"><?php echo $fatDV ?></div>
        <div id="cholesterolDV"><?php echo $cholesterolDV ?></div>
        <div id="sodiumDV"><?php echo $sodiumDV ?></div>
        <div id="carbsDV"><?php echo $carbsDV ?></div>
        <div id="totalWeekCals"><?php echo $totalWeekCals ?></div>
        <div id="totalWeekFat"><?php echo $totalWeekFat ?></div>
        <div id="totalWeekCholesterol"><?php echo $totalWeekCholesterol ?></div>
        <div id="totalWeekSodium"><?php echo $totalWeekSodium ?></div>
        <div id="totalWeekCarbs"><?php echo $totalWeekCarbs ?></div>
        <div id="totalWeekProtein"><?php echo $totalWeekProtein ?></div>
        <div id="totalSixDaysCals"><?php echo $totalSixDaysCals ?></div>
        <div id="totalSixDaysFat"><?php echo $totalSixDaysFat ?></div>
        <div id="totalSixDaysCholesterol"><?php echo $totalSixDaysCholesterol ?></div>
        <div id="totalSixDaysSodium"><?php echo $totalSixDaysSodium ?></div>
        <div id="totalSixDaysCarbs"><?php echo $totalSixDaysCarbs ?></div>
        <div id="totalSixDaysProtein"><?php echo $totalSixDaysProtein ?></div>
        <div id="totalFiveDaysCals"><?php echo $totalFiveDaysCals ?></div>
        <div id="totalFiveDaysFat"><?php echo $totalFiveDaysFat ?></div>
        <div id="totalFiveDaysCholesterol"><?php echo $totalFiveDaysCholesterol ?></div>
        <div id="totalFiveDaysSodium"><?php echo $totalFiveDaysSodium ?></div>
        <div id="totalFiveDaysCarbs"><?php echo $totalFiveDaysCarbs ?></div>
        <div id="totalFiveDaysProtein"><?php echo $totalFiveDaysProtein ?></div>
        <div id="totalFourDaysCals"><?php echo $totalFourDaysCals ?></div>
        <div id="totalFourDaysFat"><?php echo $totalFourDaysFat ?></div>
        <div id="totalFourDaysCholesterol"><?php echo $totalFourDaysCholesterol ?></div>
        <div id="totalFourDaysSodium"><?php echo $totalFourDaysSodium ?></div>
        <div id="totalFourDaysCarbs"><?php echo $totalFourDaysCarbs ?></div>
        <div id="totalFourDaysProtein"><?php echo $totalFourDaysProtein ?></div>
        <div id="totalThreeDaysCals"><?php echo $totalThreeDaysCals ?></div>
        <div id="totalThreeDaysFat"><?php echo $totalThreeDaysFat ?></div>
        <div id="totalThreeDaysCholesterol"><?php echo $totalThreeDaysCholesterol ?></div>
        <div id="totalThreeDaysSodium"><?php echo $totalThreeDaysSodium ?></div>
        <div id="totalThreeDaysCarbs"><?php echo $totalThreeDaysCarbs ?></div>
        <div id="totalThreeDaysProtein"><?php echo $totalThreeDaysProtein ?></div>
        <div id="totalTwoDaysCals"><?php echo $totalTwoDaysCals ?></div>
        <div id="totalTwoDaysFat"><?php echo $totalTwoDaysFat ?></div>
        <div id="totalTwoDaysCholesterol"><?php echo $totalTwoDaysCholesterol ?></div>
        <div id="totalTwoDaysSodium"><?php echo $totalTwoDaysSodium ?></div>
        <div id="totalTwoDaysCarbs"><?php echo $totalTwoDaysCarbs ?></div>
        <div id="totalTwoDaysProtein"><?php echo $totalTwoDaysProtein ?></div>
        <div id="totalWeekCals"><?php echo $totalWeekCals ?></div>
        <div id="totalWeekFat"><?php echo $totalWeekFat ?></div>
        <div id="totalWeekCholesterol"><?php echo $totalWeekCholesterol ?></div>
        <div id="totalWeekSodium"><?php echo $totalWeekSodium ?></div>
        <div id="totalWeekCarbs"><?php echo $totalWeekCarbs ?></div>
        <div id="totalWeekProtein"><?php echo $totalWeekProtein ?></div>
        <div id="totalSixDaysCals"><?php echo $totalSixDaysCals ?></div>
        <div id="totalSixDaysFat"><?php echo $totalSixDaysFat ?></div>
        <div id="totalSixDaysCholesterol"><?php echo $totalSixDaysCholesterol ?></div>
        <div id="totalSixDaysSodium"><?php echo $totalSixDaysSodium ?></div>
        <div id="totalSixDaysCarbs"><?php echo $totalSixDaysCarbs ?></div>
        <div id="totalSixDaysProtein"><?php echo $totalSixDaysProtein ?></div>
        <div id="totalFiveDaysCals"><?php echo $totalFiveDaysCals ?></div>
        <div id="totalFiveDaysFat"><?php echo $totalFiveDaysFat ?></div>
        <div id="totalFiveDaysCholesterol"><?php echo $totalFiveDaysCholesterol ?></div>
        <div id="totalFiveDaysSodium"><?php echo $totalFiveDaysSodium ?></div>
        <div id="totalFiveDaysCarbs"><?php echo $totalFiveDaysCarbs ?></div>
        <div id="totalFiveDaysProtein"><?php echo $totalFiveDaysProtein ?></div>
        <div id="totalFourDaysCals"><?php echo $totalFourDaysCals ?></div>
        <div id="totalFourDaysFat"><?php echo $totalFourDaysFat ?></div>
        <div id="totalFourDaysCholesterol"><?php echo $totalFourDaysCholesterol ?></div>
        <div id="totalFourDaysSodium"><?php echo $totalFourDaysSodium ?></div>
        <div id="totalFourDaysCarbs"><?php echo $totalFourDaysCarbs ?></div>
        <div id="totalFourDaysProtein"><?php echo $totalFourDaysProtein ?></div>
        <div id="totalThreeDaysCals"><?php echo $totalThreeDaysCals ?></div>
        <div id="totalThreeDaysFat"><?php echo $totalThreeDaysFat ?></div>
        <div id="totalThreeDaysCholesterol"><?php echo $totalThreeDaysCholesterol ?></div>
        <div id="totalThreeDaysSodium"><?php echo $totalThreeDaysSodium ?></div>
        <div id="totalThreeDaysCarbs"><?php echo $totalThreeDaysCarbs ?></div>
        <div id="totalThreeDaysProtein"><?php echo $totalThreeDaysProtein ?></div>
        <div id="totalTwoDaysCals"><?php echo $totalTwoDaysCals ?></div>
        <div id="totalTwoDaysFat"><?php echo $totalTwoDaysFat ?></div>
        <div id="totalTwoDaysCholesterol"><?php echo $totalTwoDaysCholesterol ?></div>
        <div id="totalTwoDaysSodium"><?php echo $totalTwoDaysSodium ?></div>
        <div id="totalTwoDaysCarbs"><?php echo $totalTwoDaysCarbs ?></div>
        <div id="totalTwoDaysProtein"><?php echo $totalTwoDaysProtein ?></div>-->
    </div>
    <div class="col-md-12 row">
        <div class="col-md-10">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>
    <div class="col-md-12 row">
        <a href="index.php" class="back-btn offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>

<script src="../Scripts/nutrition.js"></script>