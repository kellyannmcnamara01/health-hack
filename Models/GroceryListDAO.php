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

    /*public function updateUserListId($db) {
        $query_updateListId = "UPDATE USERS SET list_id = :list_id WHERE user_id = :user_id";
        $pdo_statement = $db->prepare($query_updateListId);
        $pdo_statement->bindValue(":list_id", $list_id);
        $pdo_statement->bindValue(":user_id", $user_id);
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
    }*/

    public function populateVeggieList($db) {
        $query_veggieList = "SELECT * FROM FOOD_ITEMS WHERE category = 'Vegetables' OR category = 'Grains'";
        $pdo_statement = $db->prepare($query_veggieList);
        $pdo_statement->execute();
        $veggieList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $veggieList;
    }

    public function populateAtkinsList($db) {
        $query_atkinsList = "SELECT * FROM FOOD_ITEMS WHERE ((carbs * 4)/ calories) <= 0.2 OR calories <= 40";
        $pdo_statement = $db->prepare($query_atkinsList);
        $pdo_statement->execute();
        $atkinsList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $atkinsList;
    }

    public function populateGlutenFreeList($db) {
        $query_glutenFreeList = "SELECT * FROM FOOD_ITEMS WHERE gluten_free = 1";
        $pdo_statement = $db->prepare($query_glutenFreeList);
        $pdo_statement->execute();
        $glutenFreeList = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $glutenFreeList;
    }
    public function addFoodDiaryEntry($db) {
        $query_foodDiaryEntry = "INSERT INTO FOOD_TRACKING_LISTS
                                  VALUES (:food_item_id, :meal, :servings_count, :timeInput, :track_id, :user_id )";
        $pdo_statement = $db->prepare($query_foodDiaryEntry);
        $pdo_statement->bindValue(":food_item_id", $food_item_id);
        $pdo_statement->bindValue(":meal", $meal);
        $pdo_statement->bindValue(":servings_count", $servings_count);
        $pdo_statement->bindValue(":timeInput", $timestamp);
        $pdo_statement->bindValue("track_id", $track_id);
        $pdo_statement->bindValue(":user_id", $user_id);
        $pdo_statement->execute();
        $pdo_statement->closeCursor();
    }
}
