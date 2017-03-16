<?php
    //include the header
    require_once "../Common Views/Header.php";

    //include the sidebar
    require_once "../Common Views/sidebar.php";

    //include the populate-grocerylist.php file
    require_once "../functions/populate-grocerylists.php";

    //create an empty var for the grocery list options
    $grocery_list__options = "";
    $grocery_list__options_err = "";


    //once the user submits run the following code
    if(isset($_POST['grocery_list__submit'])) {

        //create a new database class object
        require_once '../Models/Database.php';
        $dbconn = new Database();
        $db = $dbconn->getDb();

        //create a new grocery list class object and set the value
        require_once '../Models/GroceryList.php';
        $g_list = new GroceryList();
        //$g_list->setListName();


        //grab user input
        //$grocery_list_options = $_POST['grocery_lists'];

        //check for validation
        if(!isset($_POST['grocery_lists'])) {
            $grocery_list__options_err = "please choose a grocery list";
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
                <div class="btn-group" data-toggle="buttons">
                    <!--<label class="btn btn-primary" for="grocery_list_1"><input type="radio" name="grocery_lists" id="grocery_list__1">Vegetarian</label>
                    <label class="btn btn-primary" for="grocery_list_2"><input type="radio" name="grocery_lists" id="grocery_list__2">Atkins</label>
                    <label class="btn btn-primary" for="grocery_list_2"><input type="radio" name="grocery_lists" id="grocery_list__2">Gluten Free</label>-->
                    <?php grocery_list__options() ?>
                </div>
                <input type="submit" id="grocery_list__submit" name="grocery_list__submit" value="Submit">
            </form>
        </div>
        <p><?php echo $grocery_list__options_err; ?></p>
    </div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>