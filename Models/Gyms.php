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
            $output = "<div class='row fav-gyms'>";
            $gyms = $this->getGymsList();

            foreach($gyms as $gym) 
            {
                $output .= "<div class='col-sm-12 gym-item'>";

                $output .= "<div class='row'>";

                if ($gym['defaultGym'] == 1) {
                    $output .= "<div class='col-sm-1'><i class='fa fa-check-circle' aria-hidden='true'></i></div>";
                } else {
                    $output .= "<div class='col-sm-1'></div>";
                }

                $output .= "<div class='col-sm-2'>
                                <img src='../opt-imgs/login-photo.png' alt='gym logo' />
                            </div>";

                $output .= "<div class='col-sm-6'>";
                $output .= "<h2>".$gym['name']."</h2>";
                $output .= "<span><strong>Address:</strong> ".$gym['address']."</span>";
                $output .= "</div>";

                $output .= "<div class='col-sm-3'><form method='post'>
                                <input type='hidden' name='gym-num' value='{$gym["marker_id"]}'>
                                <input type='submit' class='btn btn-warning' name='deleteGym' value='Remove Gym'>
                            </form></div>";

                $output .= "</div>";

                $output .= "</div>";
            }

            $output .= "<div class='col-sm-9 gym-to-default'>";
            $output .= "<form id='form-def-gym' action='' method='post'>";
            
            $i = 1;
            foreach($gyms as $gym) 
            {
                $checked = "";
                if ($gym['defaultGym'] == 1) {
                    $checked = "checked";
                }
                $output .= "<div>
                                <span>$i</span>
                                <input type='radio' name='defaultGym' value='{$gym["marker_id"]}' $checked>
                            </div>";
                $i++;
            }
            if ($i != 1)
                $output .= "<div><input type='submit' class='btn btn-success' name='gymToChoose' value='Make a Default'></div>";
            $output .= "</form>";
            $output .= "</div>";

            $output .= "</div>";
            return $output;
        }

        public function deleteGymFromList($gymId)
        {
            try {
                $query = "delete from GYMS where marker_id = :gymID";

                $statement = $this->db->prepare($query);
                $statement->bindValue(':gymID', $gymId);
                $statement->execute();
                $statement->closeCursor();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            return true;
        }

        public function updateDefaultGym($gymId) 
        {
            try {
                $query = "update GYMS
                        SET defaultGym = 0";
                $statement = $this->db->prepare($query);
                $statement->execute();
                $statement->closeCursor();

                $query2 = "update GYMS
                        SET defaultGym = 1
                        WHERE marker_id = :gymID";
                $statement2 = $this->db->prepare($query2);
                $statement2->bindValue(':gymID', $gymId);
                $statement2->execute();
                $statement2->closeCursor();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            return true;
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

        public function getGymCountPerUser($userId)
        {
            try {
                $query = "select count(*) as gymCount from GYMS where user_id = :userID";
                $statement = $this->db->prepare($query);
                $statement->bindValue(':userID', $_SESSION['userId']);
                $statement->execute();
                $count = $statement->fetch();
            } catch(Exception $e) {
                return $e->getMessage();
            }
            $statement->closeCursor();
            return $count['gymCount'];
        }
    }
?>