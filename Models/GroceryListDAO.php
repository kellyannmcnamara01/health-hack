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

    public function populateUserListId($db) {
        $query_userListId = "SELECT * FROM USERS";
        $pdo_statement = $db->prepare($query_userListId);
        $pdo_statement->execute();
        $userListId = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $userListId;
    }

    public function updateUserListId($db) {
        $query_updateListId = "UPDATE USERS SET list_id = :list_id WHERE user_id = :user_id";
        $pdo_statement = $db->prepare($query_updateListId);
        $pdo_statement->bindValue(":list_id", $list_id);
        $pdo_statement->bindValue(":user_id", $user_id);
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
    }
}
