<?php

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
$gLists = $gListConn->populateGroceryLists($db);

?>

<div id="main-content" class="col-md-9 col-sm-12 col-12 row gListPicks">
    <div class="col-md-5 ">
        <h1 class="light-grey">Nutrition</h1>
        <p>Welcome to your nutrition section of Health Hack. Here you will be able to select what grocery list you'd like to base your diet off of. As well you will be able to see and add to your selected list. Finally you will also be able to track what you ate and when. This is important on your way to a healthy life style.</p>
    </div>
    <div class="feature col-md-10 col-sm-12 col-12">
        <form action="" method="post" id="grocery_list__options">
            <div id="grocery_list__options_err">
                <span class="badge badge-danger"><?php ?></span>
                <span class="badge badge-success"><?php ?></span>
                <?php echo $list_id;?>
            </div>

            <div class="row">
                <?php
                //loop through the products from the products table to create their own radio btns
                foreach($gLists as $gL) {
                    ?><div class="grocery_lists col-md-4 col-sm-6 col-12 row">
                    <p class="grocery_list__titles col-md-12"><?php echo $gL->list_name; ?></p>
                    <div class="grocery_list__details col-md-12">
                        <p><?php echo $gL->list_details; ?></p>
                        <div class="btn-group" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" name="grocery_lists" value="<?php echo $gL->list_id; ?>" required>Select List
                            </label>
                        </div>
                    </div>
                    </div><?php
                }
                ?>
            </div>
            <div id="grocery_list__submission">
                <input type="submit" id="" name="grocery_list__submit" value="Submit" class="formSubmit">
            </div>
        </form>
    </div>
</div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
