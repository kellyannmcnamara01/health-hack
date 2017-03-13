<?php

/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-09
 * Time: 1:21 PM
 */
class Database
{


    private $dsn = 'mysql:host=localhost;dbname=healthhack';
    private $username = "root";
    private $password = "";
    private $db;

    public function getDb(){

        try {
            $this->db = new PDO($this->dsn, $this->username);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'connected';

        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->db;
    }

    public function getDbWithPass($password) {
        try {
            $this->db = new PDO($this->dsn, $this->username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        return $this->db;
    }


}