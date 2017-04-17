<?php

//$user_id = 1;
//$list_id = 5;

session_start();
require_once '../redirect.php';
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;
$list_id = $userId->list_id;

//db
require_once "../Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

require_once "../Models/FoodEntriesLunch.php";
$lunch = new FoodEntriesLunch();
$lunch->setUsersId($id);

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();
$gLists = $gListConn->populateGroceryLists($db);
$userList = $gListConn->populateUserListId($db);
$todaysEntries = $gListConn->populateTodaysFoodEntries($db, $lunch);
$weeksEntries = $gListConn->populateWeeksFoodEntries($db, $lunch);
$sixDaysAgo = $gListConn->populateSixDaysAgo($db, $lunch);
$fiveDaysAgo = $gListConn->populateFiveDaysAgo($db, $lunch);
$fourDaysAgo = $gListConn->populateFourDaysAgo($db, $lunch);
$threeDaysAgo = $gListConn->populateThreeDaysAgo($db, $lunch);
$twoDaysAgo = $gListConn->populateSixDaysAgo($db, $lunch);
$todaysBreakfast = $gListConn->populateTodaysBreakfast($db, $lunch);
$todaysLunch = $gListConn->populateTodaysLunch($db, $lunch);
$todaysDinner = $gListConn->populateTodaysDinner($db, $lunch);
$todaysSnacks = $gListConn->populateTodaysSnacks($db, $lunch);

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