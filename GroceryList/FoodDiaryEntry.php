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
        <h1 class="light-grey">Food Tracker</h1>
        <p>Please fill out the below form to keep track of what you have been eating. This is where many of your results will populate from.</p>
        <div id="changeListBtn"><a class="buttonLink" href="Grocery.php">Select a New Grocery List</a></div>
        <div id="nutrition"><a class="buttonLink" href="index.php">Back to Nutrition Home Page</a></div>
    </div>
    <div class="feature col-md-10 col-sm-12 col-12">
        <form method="post" action="" id="food-diary-entry">
            <div class="form-field">
                <label for="food-item-selected">Food Item Name:</label>
                <select name="food-item-selected">
                    <?php foreach ($list as $listOutput) { ?>
                        <option value="<?php echo $listOutput->food_item_id ?>"><?php echo $listOutput->food_item_name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-field">
                <label for="meal">Meal:</label>
                <select name="meal">
                    <option value="breakfast" id="breakfast">Breakfast</option>
                    <option value="lunch" id="lunch">Lunch</option>
                    <option value="dinner" id="dinner">Dinner</option>
                    <option value="snack" id="snack">Snack</option>
                </select>
            </div>
            <div class="form-field">
                <label for="severing">Severing Size:</label>
                <input type="text" name="severing" id="severing" />
            </div>
            <div class="form-field">
                <input type="submit" />
            </div>
        </form>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
