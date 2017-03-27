<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 7:34 PM
 */
class StrengthWorkoutDAO
{
    public function insertStrengthWorkout($db, $reqObj){
        $query = "INSERT INTO STRENGTH_WORKOUTS (user_id, name) VALUES (:user_id, :name)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':name', $reqObj->getName());
        $statement->execute();
        $statement->closeCursor();

    }
    public function insertStrengthExercises($db, $reqObj){
    $query = "INSERT INTO STRENGTH_EXERCISES (name, strength_workout_id) VALUES (:name, swid)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $reqObj->getName());
    $statement->bindValue(':swid', $reqObj->getStrengthWorkoutId());
    $statement->execute();
    $statement->closeCursor();
}

}