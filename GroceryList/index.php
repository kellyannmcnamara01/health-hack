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


?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
<<<<<<< Updated upstream
    <div class="col-md-5 ">
        <h1 class="light-grey">Nutrition</h1>
        <p>Welcome to your nutrition section of Health Hack. Here you will be able to select what grocery list you'd like to base your diet off of. As well you will be able to see and add to your selected list. Finally you will also be able to track what you ate and when. This is important on your way to a healthy life style.</p>
        <p>Below you will see a list of food items that are currently in your list. If you would like to change your grocery list please use the button below..</p>
        <div id="changeListBtn"><a class="buttonLink" href="Grocery.php">Select a New Grocery List</a></div>
        <div id="enterFood"><a class="buttonLink" href="FoodDiaryEntry.php">Food Tracker</a></div>
    </div>
    <div class="feature col-md-10 col-sm-12 col-12">
        <div class="col-md-12 row foodlist-title-bar">
            <div class="col-2"><p class="foodlist-title">Food Item</p></div>
            <div class="col-2"><p class="foodlist-title">Category</p></div>
            <div class="col-1"><p class="foodlist-title">Servings</p></div>
            <div class="col-1"><p class="foodlist-title">Grams</p></div>
            <div class="col-1"><p class="foodlist-title">Calories</p></div>
            <div class="col-1"><p class="foodlist-title">Sodium</p></div>
=======
    <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-4 col-sm-4 col-4">
            <a href="Grocery.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/g-list-icon.png" alt="" />
                </div>
                <p class="text-center">Change Grocery List</p>
            </a>
        </div>
        <div class="feature col-md-4 col-sm-4 col-4">
            <a href="List.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/foodgoals-icon.png" alt="" />
                </div>
                <p class="text-center">Nutrition Listings</p>
            </a>
>>>>>>> Stashed changes
        </div>
        <div class="feature col-md-4 col-sm-4 col-4">
            <a href="FoodDiaryEntry.php" class="feature-btn">
                <div class="feature-icon">
                    <img src="../opt-imgs/foodlog-icon.png" alt="" />
                </div>
                <p class="text-center">Food Diary Eateries</p>
            </a>
        </div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
