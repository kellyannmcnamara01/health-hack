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
        $query_groceryLists = "SELECT * FROM GROCERY_LISTS";
        $pdo_statement = $db->prepare($query_groceryLists);
        $pdo_statement->execute();
        $groceryLists = $pdo_statement->fetchAll(PDO::FETCH_OBJ);
        return $groceryLists;
    }

    /*public function updateUserListId($db) {
        $query_updateListId = "INSERT INTO USERS (list_id) 
                                VALUES :list_id";
        $pdo_statement = $db->perpare($query_updateListId);
        $pdo_statement->bind(":list_id", $list_id->getListId());
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
    }*/
}
