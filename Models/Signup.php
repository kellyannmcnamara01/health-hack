<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-03-13
 * Time: 8:44 PM
 */
class Signup
{
    private $newUser;

    public function newUser($fname,$lname,$email,$password){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();

        // Query to insert new record of user
        $insert = "INSERT INTO USERS (first_name, last_name, email, password) VALUES (:fName, :lName, :email, :pass)";
        $newUser = $connect->prepare($insert);
        $newUser->bindValue(":fName", $fname);
        $newUser->bindValue(":lName", $lname);
        $newUser->bindValue(":email",$lname);
        $newUser->bindValue(":pass",$password);
        return $newUser->execute();
    }
}