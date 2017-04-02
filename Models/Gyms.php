<?php
    class Gyms
    {
        private $db;

        public function setDb($db) 
        {
            $this->db = $db;
        }

        public function getGymsList()
        {
            $query = "select * from GYMS where user_id = :userID";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':userID', $_SESSION['userId']);
            $statement->execute();
            $gyms = $statement->fetchAll();
            $statement->closeCursor();
            return $gyms;
        }

        public function displayGymList()
        {
            $output = "<div class='fav-gyms'>";
            $gyms = $this->getGymsList();

            $output .= "<form method='post'>";

            foreach($gyms as $gym) 
            {
                $output .= "<div class='gym-item'>";

                $output .= "<div>
                                <img src='../opt-imgs/login-photo.png' alt='gym logo' />
                            </div>";

                $output .= "<div>";
                $output .= "<h2>".$gym['name']."</h2>";
                $output .= "<span><strong>Address:</strong> ".$gym['address']."</span>";
                $output .= "</div>";

                $output .= "<div>Select: <input type='radio' name='defaultGym' value='{$gym["marker_id"]}'></div>";

                $output .= "</div>";
            }

            $output .= "</form>";

            $output .= "</div>";
            return $output;
        }

        public function addGymToFav($gymInfo)
        {
            try
            {
                $query = "insert into GYMS(user_id, name, address, lat, lng) 
                        values(:userID, :gymName, :gymAddress, :gymLat, :gymLng)";
                $statement = $this->db->prepare($query);
                $statement->bindValue(':userID', $_SESSION['userId']);
                $statement->bindValue(':gymName', $gymInfo->getGymName());
                $statement->bindValue(':gymAddress', $gymInfo->getGymAddress());
                $statement->bindValue(':gymLat', $gymInfo->getGymLat());
                $statement->bindValue(':gymLng', $gymInfo->getGymLng());
                $statement->execute();
            } catch(Exception $e) {
                return $e->getMessage();
            }
            $statement->closeCursor();
            return true;
        }
    }
?>