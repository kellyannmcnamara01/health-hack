<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-05
 * Time: 6:28 PM
 */
class RoutineDAO
{
    public function insertRoutine ($db, $reqObj)
    {
        $query = "INSERT INTO ROUTINES (user_id, name, monday_strength, monday_cardio, tuesday_strength, tuesday_cardio,
wednesday_strength, wednesday_cardio, thursday_strength, thursday_cardio, friday_strength, friday_cardio,
saturday_strength, saturday_cardio, sunday_strength, sunday_cardio, active) VALUES (:user_id, :name, :monday_strength, :monday_cardio, :tuesday_strength, :tuesday_cardio,
:wednesday_strength, :wednesday_cardio, :thursday_strength, :thursday_cardio, :friday_strength, :friday_cardio,
:saturday_strength, :saturday_cardio, :sunday_strength, :sunday_cardio, :active)";
        $statement = $db->prepare($query);
        $statement->bindValue(':user_id', $reqObj->getUserId());
        $statement->bindValue(':active', $reqObj->getActive());
        $statement->bindValue(':name', $reqObj->getName());
        $statement->bindValue(':monday_strength', $reqObj->getMondayStrength());
        $statement->bindValue(':monday_cardio', $reqObj->getMondayCardio());
        $statement->bindValue(':tuesday_strength', $reqObj->getTuesdayStrength());
        $statement->bindValue(':tuesday_cardio', $reqObj->getTuesdayCardio());
        $statement->bindValue('wednesday_strength', $reqObj->getWednesdayStrength());
        $statement->bindValue('wednesday_cardio', $reqObj->getWednesdayCardio());
        $statement->bindValue(':thursday_strength', $reqObj->getThursdayStrength());
        $statement->bindValue(':thursday_cardio', $reqObj->getThursdayCardio());
        $statement->bindValue(':friday_strength', $reqObj->getFridayStrength());
        $statement->bindValue(':friday_cardio', $reqObj->getFridayCardio());
        $statement->bindValue(':saturday_strength', $reqObj->getSaturdayStrength());
        $statement->bindValue(':saturday_cardio', $reqObj->getSaturdayCardio());
        $statement->bindValue(':sunday_strength', $reqObj->getSundayStrength());
        $statement->bindValue(':sunday_cardio', $reqObj->getSundayCardio());
        $statement->execute();
        $statement->closeCursor();

    }
    public function setInactive($db){
         $query = "UPDATE ROUTINES set active = 'no' WHERE active = 'yes'";
         $statement = $db->prepare($query);
         $statement->execute();
         $statement->closeCursor();
    }
    public function setActive($db, $reqObj){
        $query = "UPDATE ROUTINES SET active = 'yes' WHERE routine_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $reqObj->getRoutineId());
        $statement->execute();
        $statement->closeCursor();
}
    public function getRoutines($db){
        $query = "SELECT * FROM ROUTINES";
        $statement = $db->prepare($query);
        $statement->execute();
        $routines = $statement->fetchAll();
        $statement->closeCursor();
        return $routines;
    }
    public function deleteRoutine($db, $reqObj){
        $query = "DELETE FROM ROUTINES WHERE routine_id = :routine_id";
        $statement = $db->prepare($query);
        $statement->bindValue(':routine_id', $reqObj->getRoutineId());
        $statement->execute();
        $statement->closeCursor();
}

    }