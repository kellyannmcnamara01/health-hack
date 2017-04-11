<?php
    class FitnessProgress 
    {
        private $db;

        public function setDb($db) 
        {
            $this->db = $db;
        }

        public function getStrWorkoutsForUser($userId)
        {
            $query = "select strength_id, strength_workout_name from STRENGTH_WORKOUTS where user_id = :userID";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":userID", $userId);
            $statement->execute();
            $strength_workouts = $statement->fetchAll();

            $statement->closeCursor();
            return $strength_workouts;
        }

        public function getStrExercisesForWorkout($strWorkoutId)
        {
            $query = "select exercise_id, exercise_name from STRENGTH_EXERCISES where strength_workout_id = :strID";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":strID", $strWorkoutId);
            $statement->execute();
            $strength_exercises = $statement->fetchAll();

            $statement->closeCursor();
            return $strength_exercises;
        }

        public function getCompletedStrWorkouts($workoutId, $month, $year)
        {
            $query = "select * from COMPLETED_STRENGTH_EXERCISES cse
                      where strength_id = :workoutId and cse.date LIKE :Year'-':Month'-%'";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':workoutId', $workoutId);
            $statement->bindValue(':Year', $year);
            $statement->bindValue(':Month', $month);
            $statement->execute();

            $compl_workouts = $statement->fetchAll();
            $statement->closeCursor();
            return $compl_workouts;
        }

        public function getStrengthStatsForMonthYear2($month, $year, $userId)
        {
            $dateFormat = $year."-".$month."-%";
            $query = "select cse.completed_exercise_id, cse.strength_id, sw.strength_workout_name, cse.exercise_name, weight, set_1, set_2, set_3, set_4, set_5, cse.date
                      from COMPLETED_STRENGTH_EXERCISES cse
                      join STRENGTH_WORKOUTS sw on sw.strength_id = cse.strength_id
                      join STRENGTH_EXERCISES se on se.exercise_id = cse.exercise_id
                      where sw.user_id = :userID and cse.date LIKE :dateF";
                      //join STRENGTH_WORKOUTS sw on sw.strength_id = cse.strength_id
            $statement = $this->db->prepare($query);
            $statement->bindValue(':userID', $userId);
            $statement->bindValue(':dateF', $dateFormat);
            //$statement->bindValue(':Month', $month);
            $statement->execute();

            $compl_exersices = $statement->fetchAll();
            $statement->closeCursor();
            return $compl_exersices;
        }

        public function getStrengthStatsForMonthYear($month, $year, $userId) 
        {
            $completed_strengths_exercises = array();
            $strength_workouts = $this->getStrWorkoutsForUser($userId);
            
            foreach($strength_workouts as $strength_workout) 
            {
                $compl_exerc = $this->getCompletedStrWorkouts($strength_workout['strength_id'], $month, $year);
                array_push($completed_strengths_exercises, $compl_exerc);
            }

            //$complExercises = json_encode($completed_strengths_exercises);
            //header("Content-Type: application/json");
            return $strength_workouts;
            //$query = "select * from COMPLETED_STRENGTH_EXERCISES where"
        }

        public function progressTemplate()
        {
            $output = "";

            return $output;
        }
    }
?>