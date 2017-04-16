<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-12
 * Time: 10:16 PM
 */
class Friends
{
        public function addFriendByEmail($friendEmail,$userId,$userEmail)
        {
            //est. connection to DB
            $db = new Database();
            $connect = $db->getDbFromAWS();

            // INSERT => Make new friend by their email
            $insert = "INSERT INTO FREINDS (friend_id, user_id, email) VALUES ((SELECT user_id from USERS WHERE email = :friendEmail), :userId, :userEmail)";
            // prepare statement
            $InsertStmt = $connect->prepare($insert);
            //bind values for $friendEmail, $userId, $userEmail
            $InsertStmt->bindValue(":friendEmail", $friendEmail);
            $InsertStmt->bindValue(":userId", $userId);
            $InsertStmt->bindValue(":userEmail", $userEmail);

            return $InsertStmt->execute();
        }

        public function displayFriends($userId)
        {
            //est. connection to DB
            $db = new Database();
            $connect = $db->getDbFromAWS();
            $return = array();

            $select = "SELECT * FROM FRIENDS AS f 
                       JOIN USERS AS u 
                       on f.user_id = u.user_id
                       WHERE u.user_id = :uId";
            // prepare statement
            $selectStmt = $connect->prepare($select);
            // bind values
            $selectStmt->bindValue("uId", $userId);
            $selectStmt->execute();
            $return = $selectStmt->fetch(PDO::FETCH_OBJ);
            $selectStmt->closeCursor();

            return $return;

        }
}