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
//$todaysEntries = $gListConn->populateTodaysFoodEntries($db);
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
    <div class="col-md-5 ">
        <h1 class="light-grey">Food Tracker</h1>
        <p>Please fill out the below form to keep track of what you have been eating. This is where many of your results will populate from..</p>
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
                <input id="foodEntrySubmit" name="foodEntrySubmit" type="submit" />
            </div>
        </form>
        <h3>Breakfast</h3>
        <div class="col-md-12 row">
            <div class="col-md-4"><strong>food item name</strong></div>
            <div class="col-md-2"><strong>servings count</strong></div>
            <div class="col-md-1"><strong>calories</strong></div>
            <div class="col-md-1"><strong>sodium</strong></div>
            <div class="col-md-1"><strong>carbs</strong></div>
            <div class="col-md-1"><strong>protein</strong></div>
        </div>
        <div class="col-md-12 row">
            <?php foreach ($todaysBreakfast as $today){ ?>
                <div class="col-md-4"><?php echo $today->food_item_name ?></div>
                <div class="col-md-2"><?php echo $today->servings_count ?></div>
                <div class="col-md-1"><?php echo $today->calories ?></div>
                <div class="col-md-1"><?php echo $today->sodium ?></div>
                <div class="col-md-1"><?php echo $today->carbs ?></div>
                <div class="col-md-1"><?php echo $today->protein ?></div>
            <?php } ?>
        </div>
        <br><br>
        <h3>Lunch</h3>
        <div class="col-md-12 row">
            <div class="col-md-4"><strong>food item name</strong></div>
            <div class="col-md-2"><strong>servings count</strong></div>
            <div class="col-md-1"><strong>calories</strong></div>
            <div class="col-md-1"><strong>sodium</strong></div>
            <div class="col-md-1"><strong>carbs</strong></div>
            <div class="col-md-1"><strong>protein</strong></div>
        </div>
        <div class="col-md-12 row">
            <?php foreach ($todaysLunch as $today){ ?>
                <div class="col-md-4"><?php echo $today->food_item_name ?></div>
                <div class="col-md-2"><?php echo $today->servings_count ?></div>
                <div class="col-md-1"><?php echo $today->calories ?></div>
                <div class="col-md-1"><?php echo $today->sodium ?></div>
                <div class="col-md-1"><?php echo $today->carbs ?></div>
                <div class="col-md-1"><?php echo $today->protein ?></div>
            <?php } ?>
        </div>
        <br><br>
        <h3>Dinner</h3>
        <div class="col-md-12 row">
            <div class="col-md-4"><strong>food item name</strong></div>
            <div class="col-md-2"><strong>servings count</strong></div>
            <div class="col-md-1"><strong>calories</strong></div>
            <div class="col-md-1"><strong>sodium</strong></div>
            <div class="col-md-1"><strong>carbs</strong></div>
            <div class="col-md-1"><strong>protein</strong></div>
        </div>
        <div class="col-md-12 row">
            <?php foreach ($todaysDinner as $today){ ?>
                <div class="col-md-4"><?php echo $today->food_item_name ?></div>
                <div class="col-md-2"><?php echo $today->servings_count ?></div>
                <div class="col-md-1"><?php echo $today->calories ?></div>
                <div class="col-md-1"><?php echo $today->sodium ?></div>
                <div class="col-md-1"><?php echo $today->carbs ?></div>
                <div class="col-md-1"><?php echo $today->protein ?></div>
            <?php } ?>
        </div>
        <br><br>
        <h3>Snacks</h3>
        <div class="col-md-12 row">
            <div class="col-md-4"><strong>food item name</strong></div>
            <div class="col-md-2"><strong>servings count</strong></div>
            <div class="col-md-1"><strong>calories</strong></div>
            <div class="col-md-1"><strong>sodium</strong></div>
            <div class="col-md-1"><strong>carbs</strong></div>
            <div class="col-md-1"><strong>protein</strong></div>
        </div>
        <div class="col-md-12 row">
            <?php foreach ($todaysSnacks as $today){ ?>
                <div class="col-md-4"><?php echo $today->food_item_name ?></div>
                <div class="col-md-2"><?php echo $today->servings_count ?></div>
                <div class="col-md-1"><?php echo $today->calories ?></div>
                <div class="col-md-1"><?php echo $today->sodium ?></div>
                <div class="col-md-1"><?php echo $today->carbs ?></div>
                <div class="col-md-1"><?php echo $today->protein ?></div>
            <?php } ?>
        </div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
