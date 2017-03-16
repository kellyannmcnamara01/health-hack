<?php

/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-03-12
 * Time: 12:32 PM
 */
class GroceryListDAO
{
    public function populateGroceryLists($db) {
        $query_groceryLists = "SELECT list_name FROM GROCERY_LISTS";
        $pdo_statement = $db->prepare($query_groceryLists);
        $pdo_statement = execute();
        $groceryLists = $pdo_statement->fetchAll(PDO::FETCH_OBJ);
    }
}