<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-10
 * Time: 4:52 PM
 */
require_once 'Database.php';

class Profile
{
    private $userInfo, $validUser, $return;

    public function UserInfo($userid,$age,$weight,$profileImg){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();

        // insert statement (into PROFILES tbl)
        $insert = "INSERT INTO PROFILES (user_id, age, weight, profile_image) VALUES (:userid, :age, :weight, :profileImg)";

        //prepare query
        $Profile = $connect->prepare($insert);
        //bind values
        $Profile->bindValue(":userid", $userid);
        $Profile->bindValue(":age", $age);
        $Profile->bindValue(":weight", $weight);
        $Profile->bindValue(":profileImg", $profileImg);

        // return the execution of the insert statement
        return $Profile->execute();
    }
    public function GetUserIdByToken($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();
        $return = array();

        // query to grab user info by access_token
        $select = "SELECT user_id from USERS WHERE access_token = :token";

        //prepare query
        $userInfo = $connect->prepare($select);
        //bind value
        $userInfo->bindValue(":token", $id);
        //execute
        $userInfo->execute();
        //Allow for access of return values by object reference
        $return = $userInfo->fetch(PDO::FETCH_OBJ);
        $userInfo->closeCursor();

        return $return;
    }

    public function GetUserIdByResetToken($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();
        $return = array();

        // query to grab user info by access_token
        $select = "SELECT user_id from USERS WHERE resetToken = :token";

        //prepare query
        $userInfo = $connect->prepare($select);
        //bind value
        $userInfo->bindValue(":token", $id);
        //execute
        $userInfo->execute();
        //Allow for access of return values by object reference
        $return = $userInfo->fetch(PDO::FETCH_OBJ);
        $userInfo->closeCursor();

        return $return;
    }

    public function ResetPassword($password,$id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();

        //encrypt password using SHA1
        $Newpassword = sha1($id . $password);

        $update = "UPDATE USERS SET password = :password WHERE user_id = :id";
        // prepare statement
        $updateStmt = $connect->prepare($update);
        //bind values for $token, $email
        $updateStmt->bindValue(":password", $Newpassword);
        $updateStmt->bindValue(":id", $id);

        return $updateStmt->execute();
    }
}