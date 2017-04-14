<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-14
 * Time: 4:02 PM
 */

if(!isset($_SESSION['user'])){
    header("Location:Landing.php");
}

