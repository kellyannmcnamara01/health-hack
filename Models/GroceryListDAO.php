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

    public function populateTodaysFoodEntries($db){
        $query_todaysFoodEntries = "SELECT food_item_name, servings_count, calories, sodium, carbs, protein, meal, FOOD_TRACKING_LISTS.user_id
                                    FROM FOOD_ITEMS, FOOD_TRACKING_LISTS
                                    WHERE FOOD_ITEMS.food_item_id = FOOD_TRACKING_LISTS.food_item_id
                                      AND FOOD_TRACKING_LISTS.user_id = :user_id
	                                  AND time_stamp = CURDATE();";
        $pdo_statement = $db->prepare($query_todaysFoodEntries);
        $pdo_statement->bindValue(":user_id", 1);
        $pdo_statement->execute();
        $todaysFoodEntries = $pdo_statement->fetchALL(PDO::FETCH_OBJ);
        return $todaysFoodEntries;

    }
}
