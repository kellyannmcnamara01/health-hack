<?php
    //include the header
    require_once "../Common Views/Header.php";

    //include the sidebar
    require_once "../Common Views/sidebar.php";

    //db
    require_once "../Models/Database.php";
    $dbConn = new Database();
    $db = $dbConn->getDbTwo();

    //include groceryList DAO
    //require_once "../Models/GroceryListDAO.php";
    //$gListConn = new GroceryListDAO();
    //$gLists = $gListConn->populateGroceryLists($db);

    //create an empty var for the grocery list options
    $grocery_list__options = "";
    $grocery_list__options_err = "";

    //create a function to populate grocery list btns
    function grocery_list__options() {
        //create an array to hold said options
        $grocery_lists = ['Vegetarian', 'Atkins', 'Gluten Free'];
        //create a foreach loop that populates the new options
        foreach($grocery_lists as $gl) {
            ?><label class="btn btn-primary"><input type="radio" name="grocery_lists" value="<?php echo strtolower ($gl); ?>"><?php echo $gl; ?></label><?php
        }
    }


    //once the user submits run the following code
    if(isset($_POST['grocery_list__submit'])) {

        //create a new grocery list class object and set the value
        require_once '../Models/GroceryList.php';
        $g_list = new GroceryList();
        //$g_list->setListId($list_id);
        //$g_list->setListName($list_name);


        //check for validation
        if(!isset($_POST['grocery_lists'])) {
            $grocery_list__options_err = "please choose a grocery list";
        } else {
            $grocery_list__options_err = $_POST['grocery_lists'];
        }

    }

?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="col-md-5">
            <h1 class="light-grey">Grocery Lists</h1>
            <p>Please select a grocery list from the following options. This list will be your main outlining diet for your journey with us here at Health Hack. </p>
        </div>
        <div class="feature col-md-12 col-sm-12 col-12">
            <form action="" method="post" id="grocery_list__options">
                <p><?php echo $grocery_list__options_err; ?></p>
                <div class="btn-group" data-toggle="buttons">
                    <!--<label class="btn btn-primary" for="grocery_list_1"><input type="radio" name="grocery_lists" id="grocery_list__1">Vegetarian</label>
                    <label class="btn btn-primary" for="grocery_list_2"><input type="radio" name="grocery_lists" id="grocery_list__2">Atkins</label>
                    <label class="btn btn-primary" for="grocery_list_2"><input type="radio" name="grocery_lists" id="grocery_list__2">Gluten Free</label>-->
                    <?php grocery_list__options() ?>
                </div>
                <input type="submit" id="grocery_list__submit" name="grocery_list__submit" value="Submit">
            </form>
        </div>
        <?php
        //loop through the products from the products table to create their own radio btns
        //foreach($gLists as $gL) {
        //    echo "<p>" . $gL->list_name . "</p>";
        //}
        ?>
    </div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>