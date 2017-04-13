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
    <div class="col-md-5 ">
        <h1 class="light-grey">Nutrition</h1>
        <p>Welcome to your nutrition section of Health Hack. Here you will be able to select what grocery list you'd like to base your diet off of. As well you will be able to see and add to your selected list. Finally you will also be able to track what you ate and when. This is important on your way to a healthy life style.</p>
        <p>Below you will see a list of food items that are currently in your list. If you would like to change your grocery list please use the button below.</p>
        <div class="col-md-12 row">
            <div class="col-md-7">
                <button class="buttonLink" href="Grocery.php">Select a New Grocery List</button>
            </div>
            <div class="col-md-5">
                <button class="buttonLink" href="FoodDiaryEntry.php">Food Tracker</button>
            </div>
        </div>
    </div>
    <div class="feature col-md-10 col-sm-12 col-12">
        <div class="col-md-12 row foodlist-title-bar">
            <div class="col-2"><p class="foodlist-title">Food Item</p></div>
            <div class="col-2"><p class="foodlist-title">Category</p></div>
            <div class="col-1"><p class="foodlist-title">Servings</p></div>
            <div class="col-1"><p class="foodlist-title">Grams</p></div>
            <div class="col-1"><p class="foodlist-title">Calories</p></div>
            <div class="col-1"><p class="foodlist-title">Sodium</p></div>
        </div>
        <?php
        foreach ($list as $listOutput){
            ?>
            <div class="col-md-12 row">
                <div class="col-md-2"><p><?php echo $listOutput->food_item_name ?></p></div>
                <div class="col-md-2"><p><?php echo $listOutput->category ?></p></div>
                <div class="col-md-1"><p><?php echo $listOutput->serving_count ?></p></div>
                <div class="col-md-1"><p><?php echo $listOutput->grams ?> g</p></div>
                <div class="col-md-1"><p><?php echo $listOutput->calories ?></p></div>
                <div class="col-md-1"><p><?php echo $listOutput->sodium ?> mg</p></div>
            </div>
            <?php
        }
        ?>
        <div class="col-md-12 row">
            <!--
                <form method="post" action="#" id="addFood">
                    <div class="form-field">
                        <label for="user_food_item" class="">Food Item Name</label>
                        <input type="text" id="user_food_item" name="user_food_item" class="" placeholder="Food Item Name" />
                    </div>
                </form>
            -->
        </div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
