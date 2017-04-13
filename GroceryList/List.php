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

//DV% vars
$dailyFat = ($list[2]->fat / 65) * 100;

//include the header
require_once "../Common Views/Header.php";

//include the sidebar
require_once "../Common Views/sidebar.php";


?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div class="col-md-6 ">
        <h1 class="light-grey">Nutrition</h1>
<<<<<<< Updated upstream
        <p>Welcome to your nutrition section of Health Hack. Here you will be able to select what grocery list you'd like to base your diet off of. As well you will be able to see and add to your selected list. Finally you will also be able to track what you ate and when. This is important on your way to a healthy life style.</p>
        <p>Below you will see a list of food items that are currently in your list. If you would like to change your grocery list please use the button below..</p>
=======
        <p>Welcome to your nutrition list by Health Hack. Here you will be able to see and add to your selected list. </p>
        <p>Below you will see a list of food items that are currently in your list. If you would like to see the full nutrition facts for a food item please click on the name and it will expand to show more information. If you would like to change your grocery list please use the button below.</p>
>>>>>>> Stashed changes
        <div class="col-md-12 row">
            <div class="col-md-7">
                <button class="buttonLink" href="Grocery.php">Select a New Grocery List</button>
            </div>
            <div class="col-md-5">
                <button class="buttonLink" href="FoodDiaryEntry.php">Food Tracker</button>
            </div>
        </div>
    </div>

    <div class="panel-group col-md-10 row" id="list-accordion">
        <?php
            foreach($list as $listOutput) {
        ?>
            <div class="panel panel-default col-md-4">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#list-accordion" href="#list-item-<?php echo $listOutput->food_item_id ?>">
                            <?php echo $listOutput->food_item_name ?>
                        </a>
                    </h4>
                </div>
                <div id="list-item-<?php echo $listOutput->food_item_id ?>" class="panel-collapse collapse in">
                    <div class="panel-body row">
                        <div class="col-md-12">Category: <?php echo $listOutput->category ?></div>
                        <div class="col-md-12">Serving Size <?php echo $listOutput->grams ?> g</div>
                        <div class="col-md-12 row">
                            <div class="col-md-6">Amount Per Serving</div>
                            <div class="col-md-6">% Daily Value</div>
                        </div>
                        <div class="col-md-12">Calories <?php echo $listOutput->calories ?></div>
                        <div class="col-md-9">
                            <div>Total Fat <?php echo $listOutput->fat ?>g</div>
                            <div>Cholesterol <?php echo $listOutput->cholesterol ?>mg</div>
                            <div>Sodium <?php echo $listOutput->sodium ?> mg</div>
                            <div>Total Carbs <?php echo $listOutput->carbs ?> g</div>
                            <div>Protein <?php echo $listOutput->protein ?> g</div>
                        </div>
                        <div class="col-md-3">
                            <div><?php echo round(($listOutput->fat / 65) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->cholesterol / 300) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->sodium / 2400) * 100) ?>%</div>
                            <div><?php echo round(($listOutput->carbs / 300) * 100) ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
