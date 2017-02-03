<?php

/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-02-03
 * Time: 7:40 AM
 */
class Validation
{
    //create a function to check for a postal code
    public function checkPostal($key){
        //regex for postal code
        $postalRegEx = "/^([ABCEGHJKLMNPRSTVXY]{1}\d[ABCEGHJKLMNPRSTVXY]{1}(-|\s)?\d[ABCEGHJKLMNPRSTVXY]{1}\d|\d{5}(-\d{4})?)$/i";

        //create if statement to check if the postal code matches the regExx, if it doesn't or if it is empty
        if(empty($key)){
            $postalMsg = "Postal Empty";
        } else if(!preg_match($postalRegEx, $key)){
            $postalMsg = "Postal Failed";
        } else {
            $postalMsg = "Postal Passed";
        }
        //return the $postalMsg output
        return $postalMsg;
    }

    //create a function to check for a phone number
    public function checkPhone($key){
        //regex for phone number
        $phoneRegEx = "/^\(?[0-9]{3}(-|\)| )?[0-9]{3}(-| )?[0-9]{4}$/";

        //create if statement to check if the phone matches to the regEx, if it doesn't or if it is empty
        if(empty($key)){
            $phoneMsg = "Phone Empty";
        } else if(!preg_match($phoneRegEx, $key)){
            $phoneMsg = "Phone Failed";
        } else {
            $phoneMsg = "Phone Passed";
        }
        //return the $phoneMsg output
        return $phoneMsg;
    }
}