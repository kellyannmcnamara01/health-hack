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
}