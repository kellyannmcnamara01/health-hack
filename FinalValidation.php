<?php

/**
 * Created by PhpStorm.
 * User: Rahul
 * Date: 2017-02-02
 * Time: 7:39 PM
 */
class Validation
{
    private $Error=false;
    public function ValidateAddress($Address)
    {
            $AddressPattern = '/\d+ [0-9a-zA-Z ]+/';
            $this->Error = !preg_match($AddressPattern, $Address);
            return $this->Error;

    }
    //$value - email to validate
    //returns: true if valid, false - if not.
    public function validateEmail($value)
    {
        return (filter_var($value, FILTER_VALIDATE_EMAIL) === false) ? false : true;
    }

    //$nameAtr - value of name attribute
    //returns: true if radio button is selected, false - if not.
    public function radioChecked($nameAtr)
    {
        return (isset($_POST[$nameAtr]) === true) ? true : false;
    }

    public  function IsEmpty($Input)
    {


            $this->Error=empty($Input);
            return $this->Error;

    }
    public function LetterChk($Input)
    {
        $LetterPattern='/^[a-zA-Z]+$/';
        $this->Error=!preg_match($LetterPattern,$Input);
        return $this->Error;
    }
    //create a function to check for a postal code
    public function checkPostal($key){
        //regex for postal code
        $postalRegEx = "/^([ABCEGHJKLMNPRSTVXY]{1}\d[ABCEGHJKLMNPRSTVXY]{1}(-|\s)?\d[ABCEGHJKLMNPRSTVXY]{1}\d|\d{5}(-\d{4})?)$/i";

        //create if statement to check if the postal code matches the regExx, if it doesn't or if it is empty
        if(empty($key)){
            $postalMsg = "Postal Empty<br>";
        } else if(!preg_match($postalRegEx, $key)){
            $postalMsg = "Postal Failed<br>";
        } else {
            $postalMsg = "";
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
            $phoneMsg = "Phone Empty<br>";
        } else if(!preg_match($phoneRegEx, $key)){
            $phoneMsg = "Phone Failed<br>";
        } else {
            $phoneMsg = "";
        }
        //return the $phoneMsg output
        return $phoneMsg;
    }
     //function to test a password.
    public function password ($string) {
        if (preg_match('/(?=.*[[:digit:]])(?=.*[[:upper:]])[[:print:]]{12,}/', $string)){
            return true;
        } else {
            return false;
        }

    } //end of password function.

    //function to test that only digits were entered.
    public function digits ($string) {
        if (preg_match("/\d+/", $string)){
            return true;
        }
        else{
            return false;
        }
    } //end of digits function.
}