<?php

/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-03-13
 * Time: 8:44 PM
 */

require_once 'Database.php';

class Signup
{
    private $newUser, $validUser;

    public function newUser($fname,$lname,$email,$password){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();


        //encrypt password using SHA1
        $password = sha1($email . $password);

        // Query to insert new record of user
        $insert = "INSERT INTO USERS (first_name, last_name, email, password) VALUES (:fName, :lName, :email, :pass)";
        //prepare query
        $newUser = $connect->prepare($insert);
        //bind values
        $newUser->bindValue(":fName", $fname);
        $newUser->bindValue(":lName", $lname);
        $newUser->bindValue(":email",$lname);
        $newUser->bindValue(":pass",$password);
        return $newUser->execute();
    }


    public function isValidUser($email,$password){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();

        //encrypt password using SHA1
        $password = sha1($email . $password);

        $select = "SELECT user_id FROM USERS WHERE email = :email AND password = :password";
        //prepare query
        $validUser = $connect->prepare($select);
        //bind values
        $validUser->bindValue(":email", $email);
        $validUser->bindValue(":password", $password);
        $validUser->execute();
        //ensure only only result is returned
        $valid = ($validUser->rowCount() == 1);
        return $valid;
    }
}