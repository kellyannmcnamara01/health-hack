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
    //$user_id = 1;

    //setting the values
    $foodEntryGetSet = new FoodEntry();
    $foodEntryGetSet->setFoodItemId($food_item_id);
    $foodEntryGetSet->setMeal($meal);
    $foodEntryGetSet->setServingsCount($servings_count);
    $foodEntryGetSet->setTimestamp($timestamp);
    $foodEntryGetSet->setUserId($id);

    //var_dump($foodEntryGetSet->getUserId());
    $gListConn->userFoodEntry($db, $foodEntryGetSet);


}

?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">

    <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-6 col-sm-6 col-6">
            <a href="Grocery.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/g-list-icon.png" alt="" />
                </div>
                <p class="text-center">Change Grocery List</p>
            </a>
        </div>
        <div class="feature col-md-6 col-sm-6 col-6">
            <a href="List.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/foodgoals-icon.png" alt="" />
                </div>
                <p class="text-center">Nutrition Listings</p>
            </a>
        </div>
        <div class="feature col-md-6 col-sm-6 col-6">
            <a href="FoodDiaryEntry.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/foodlog-icon.png" alt="" />
                </div>
                <p class="text-center">Food Diary Eateries</p>
            </a>
        </div>
        <div class="feature col-md-6 col-sm-6 col-6">
            <a href="statistics.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/chart-icon.png" alt="" />
                </div>
                <p class="text-center">Nutrition Statistics</p>
            </a>
        </div>
    </div>
    <div class="col-md-12 row">
        <a href="../index.php" class="back-btn offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>

<script src="../Scripts/nutrition.js"></script>