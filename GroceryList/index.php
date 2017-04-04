<?php

$user_id = 1;

//include the header
require_once "../Common Views/Header.php";

//include the sidebar
require_once "../Common Views/sidebar.php";

//db
require_once "../Models/Database.php";
$dbConn = new Database();
$db = $dbConn->getDbFromAWS();

//include groceryList DAO
require_once "../Models/GroceryListDAO.php";
$gListConn = new GroceryListDAO();
$veggieList = $gListConn->populateVeggieList($db);
$atkinList = $gListConn->populateAtkinsList($db);
$glutenFreeList = $gListConn->populateGlutenFreeList($db);

?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div class="col-md-5 ">
        <h1 class="light-grey">Nutrition</h1>
        <p>Welcome to your nutrition section of Health Hack. Here you will be able to select what grocery list you'd like to base your diet off of. As well you will be able to see and add to your selected list. Finally you will also be able to track what you ate and when. This is important on your way to a healthy life style.</p>
    </div>
    <div class="feature col-md-10 col-sm-12 col-12">
        <p>hi</p>
        <?php
        foreach ($veggieList as $v){
            ?><li><?php echo $v->food_item_name ?></li><?php
        }?><br><br><?php
        foreach ($atkinList as $a){
            ?><li><?php echo $a->food_item_name ?></li><?php
        }?><br><br><?php
        foreach ($glutenFreeList as $g){
            ?><li><?php echo $g->food_item_name ?></li><?php
        }
        ?>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
