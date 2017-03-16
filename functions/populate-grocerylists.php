<?php


//create a new database class object
require_once '../Models/Database.php';
$dbconn = new Database();
$db = $dbconn->getDb();

//create a new instance of GL-DAO
require_once '../Models/GroceryListDAO.php';
$gListConn = new GroceryListDAO();
$gList = $gListConn->populateGroceryLists($db);

//create a function to populate grocery list btns
function grocery_list__options() {
    //create an array to hold said options
    $grocery_lists = ['Vegetarian', 'Atkins', 'Gluten Free'];
    //create a foreach loop that populates the new options
    foreach($grocery_lists as $gl) {
        ?><label class="btn btn-primary"><input type="radio" name="grocery_lists" value="<?php echo strtolower ($gl); ?>"><?php echo $gl; ?></label><?php
    }
}

?>