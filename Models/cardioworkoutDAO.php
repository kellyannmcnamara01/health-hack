<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-10
 * Time: 5:17 PM
 */
class cardioworkoutDAO
{
    public function insertCardio($db, $reqObj){
        $query = "INSERT INTO CARDIO_WORKOUTS (user_id, name, goal_distance, goal_time) VALUES (:user_id, :cardio_name, :goal_distance, :goal_time )";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':cardio_name', $reqObj->getName());
        $statement->bindValue(':goal_distance', $reqObj->getGoalDistance());
        $statement->bindValue(':goal_time', $reqObj->getGoalTime());
        $statement->execute();
        $statement->closeCursor();


    }

}