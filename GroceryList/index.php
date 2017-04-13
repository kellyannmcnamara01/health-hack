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
