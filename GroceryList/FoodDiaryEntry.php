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
$track_id = "";

if(isset($_POST['foodEntrySubmit'])) {

    //include the getter and setter for the food entry file
    require_once "../Models/FoodEntry.php";

    //set the vars
    $foodEntryGetSet = new FoodEntry();
    $food_item_id = $_POST["food-item-selected"];
    $meal = $_POST["meal"];
    $servings_count = $_POST["severing"];
    //$time = new DateTime();
    //$timestamp = $time->format('Y-m-d H:i:s');
    $timestamp = date("Y-m-d");
    $user_id = 1;

    //adding content query
    $query_foodDiaryEntry = "INSERT INTO FOOD_TRACKING_LISTS
                                  VALUES (:track_id, :user_id, :food_item_id, :meal, :servings_count, :timeInput )";
    $pdo_statement = $db->prepare($query_foodDiaryEntry);
    $pdo_statement->bindValue("track_id", $track_id);
    $pdo_statement->bindValue(":user_id", $user_id);
    $pdo_statement->bindValue(":food_item_id", $food_item_id);
    $pdo_statement->bindValue(":meal", $meal);
    $pdo_statement->bindValue(":servings_count", $servings_count);
    $pdo_statement->bindValue(":timeInput", $timestamp);
    $pdo_statement->execute();
    $pdo_statement->closeCursor();

}


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
                <input id="foodEntrySubmit" name="foodEntrySubmit" type="submit" />
            </div>
        </form>
        <div class="col-md-12 row">
            <?php foreach ($todaysEntries as $today){ ?>
                <div class="col-md-3"><?php echo $today->food_item_name ?></div>
                <div class="col-md-1"><?php echo $today->calories ?></div>
                <div class="col-md-1"><?php echo $today->sodium ?></div>
                <div class="col-md-1"><?php echo $today->carbs ?></div>
                <div class="col-md-1"><?php echo $today->protein ?></div>
                <div class="col-md-3"><?php echo $today->meal ?></div>
            <?php } ?>
        </div>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
