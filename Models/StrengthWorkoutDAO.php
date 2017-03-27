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
    public function insertStrengthExercises($db, $value, $reqObj){
    $query = "INSERT INTO STRENGTH_EXERCISES (name, strength_workout_id) VALUES (:name, (SELECT strength_id FROM STRENGTH_WORKOUTS WHERE name = :strength_name AND user_id = :user_id))";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $value);
    $statement->bindValue (':strength_name', $reqObj->getName());
    $statement->bindValue(':user_id', $reqObj->getUserId());
    $statement->execute();
    $statement->closeCursor();
}
public function verifyUniqueName ($db, $reqObj){
        $query = "SELECT name FROM STRENGTH_WORKOUTS WHERE user_id = :user_id";
        $statement = $db->prepare($query);
        $statement->bindValue('user_id', $reqObj->getUserId());
        $statement->execute();
        $strength_workouts = $statement->fetchAll();
        $statement->closeCursor();
        return $strength_workouts;

}

}