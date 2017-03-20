<?php
    class FitnessProgress 
    {
        private $db;

        public function setDb($db) 
        {
            $this->db = $db;
        }

        public function getStatsFromTo()
        {
            $goal_distances = array();
            $real_distances = array();
            $distances = array();

            $query = "select goal_distance, distance 
                      from cardio_workouts cw join completed_cardio_workouts ccw on cw.cardio_id = ccw.cardio_id";
            $statement = $this->db->prepare($query);
            $statement->execute();
            $distances = $statement->fetchAll();
            var_dump($distances);
            $statement->closeCursor();
        }
    }
?>