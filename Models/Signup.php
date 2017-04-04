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
    private $newUser, $validUser, $return;

    public function newUser($fname,$lname,$email,$password){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();


        //encrypt password using SHA1
        $password = sha1($email . $password);
        // assign current date & time to a variable
        $join_date = date('Y-m-d H:i:s');

        // Query to insert new record of user
        $insert = "INSERT INTO USERS (first_name, last_name, email, password, join_date) VALUES (:fName, :lName, :email, :pass, :jdate)";
        //prepare query
        $newUser = $connect->prepare($insert);
        //bind values
        $newUser->bindValue(":fName", $fname);
        $newUser->bindValue(":lName", $lname);
        $newUser->bindValue(":email",$email);
        // if the user attempts to enter an already registered email
        if (!$email){
            die("Email already registered.");
        }
        $newUser->bindValue(":pass",$password);
        $newUser->bindValue(":jdate", $join_date);
        // return execution of statement
        return $newUser->execute();
    }


    public function isValidUser($email,$password){

        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();
        $return = array();

        //encrypt password using SHA1
        $password = sha1($email . $password);

        // user_id
        // *
        try{
            $select = "SELECT * FROM USERS WHERE email = :email AND password = :password";
            //prepare query
            $validUser = $connect->prepare($select);
            //bind values
            $validUser->bindValue(":email", $email);
            $validUser->bindValue(":password", $password);
            $validUser->execute();
            $return = $validUser->fetch(PDO::FETCH_OBJ);
            $validUser->closeCursor();
        } catch (PDOException $e){
            $e->getMessage();
        }

        return $return;
    }

    public function userInfo($id){
        //est. connection to DB
        $db = new Database();
        $connect = $db->getDb();
        $return = array();

        try{
            $select = "SELECT * FROM USERS WHERE user_id = :id";
            //prepare statement
            $slctUser = $connect->prepare($select);
            $slctUser->bindValue(":id", $id);
            $slctUser->execute();
            $return = $slctUser->fetch(PDO::FETCH_OBJ);
            $slctUser->closeCursor();
        } catch (PDOException $e){
            $e->getMessage();
        }

        return $return;
    }
}