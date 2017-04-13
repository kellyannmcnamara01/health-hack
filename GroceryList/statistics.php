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
$totalCals = "";
$totalFat = "";
$totalCholesterol = "";
$totalSodium = "";
$totalCarbs = "";
$totalProtein = "";


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
        <div class="col-md-3">
            <h2 class="text-center">Daily Nutrition Intake Total</h2>
            <canvas id="nutritionChart"></canvas>
        </div>
        <div class="col-md-3">
            <h2 class="text-center">Daily Value Intake Total</h2>
            <canvas id="dvChart"></canvas>
        </div>
    </div>
    <?php foreach ($todaysEntries as $today){
        $totalCals += $today->calories;
        $totalFat += $today->fat;
        $totalCholesterol += $today->cholesterol;
        $totalSodium += $today->sodium;
        $totalCarbs += $today->carbs;
        $totalProtein += $today->protein;
        $fatDV = round(($today->fat / 65) * 100);
        $cholesterolDV = round(($today->cholesterol / 300) * 100);
        $sodiumDV = round(($today->sodium / 2400) * 100);
        $carbsDV = round(($today->carbs / 300) * 100);
    } ?>
    <div class="col-md-12">Total Cals for the day: <?php echo $totalCals ?></div>
    <div class="col-md-12">Total Fat for the day: <?php echo $totalFat ?></div>
    <div class="col-md-12">Total cholesterol for the day: <?php echo $totalCholesterol ?></div>
    <div class="col-md-12">Total sodium for the day: <?php echo $totalSodium ?></div>
    <div class="col-md-12">Total carbs for the day: <?php echo $totalCarbs ?></div>
    <div class="col-md-12">Total protein for the day: <?php echo $totalProtein ?></div>
    <div class="col-md-12">Total fat DV% for the day: <?php echo $fatDV ?>%</div>
    <div class="col-md-12">Total cholesterol DV% for the day: <?php echo $cholesterolDV ?>%</div>
    <div class="col-md-12">Total sodium DV% for the day: <?php echo $sodiumDV ?>%</div>
    <div class="col-md-12">Total carbs DV% for the day: <?php echo $carbsDV ?>%</div>
    <!--hidden div containing all of the number output-->
    <div style="display: none">
        <div id="totalCals"><?php echo $totalCals ?></div>
        <div id="totalFat"><?php echo $totalFat ?></div>
        <div id="totalCholesterol"><?php echo $totalCholesterol ?></div>
        <div id="totalSodium"><?php echo $totalSodium ?></div>
        <div id="totalCarbs"><?php echo $totalCarbs ?></div>
        <div id="totalProtein"><?php echo $totalProtein ?></div>
        <div id="fatDV"><?php echo $fatDV ?></div>
        <div id="cholesterolDV"><?php echo $cholesterolDV ?></div>
        <div id="sodiumDV"><?php echo $sodiumDV ?></div>
        <div id="carbsDV"><?php echo $carbsDV ?></div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>

<script src="../Scripts/nutrition.js"></script>