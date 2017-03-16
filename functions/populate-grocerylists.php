<?php


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