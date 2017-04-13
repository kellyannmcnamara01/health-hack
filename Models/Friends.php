<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-12
 * Time: 10:16 PM
 */
class Friends
{
        public function getFriendByEmail($friendEmail,$userId,$userEmail)
        {
            //est. connection to DB
            $db = new Database();
            $connect = $db->getDb();

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
}