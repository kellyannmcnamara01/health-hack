<?php
    require('Models/Signup.php');
    $pop = new Signup();
    //echo $pop->test("bryanstephensjournalism@gmail.com", "password") . "<br>";
    $arr = $pop->isValidUser("bryanstephensjournalism@gmail.com", "password");
    var_dump($arr);
?>