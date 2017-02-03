<?php
/**
 * Created by PhpStorm.
 * User: kellyannmcnamara
 * Date: 2017-02-03
 * Time: 7:46 AM
 */

//include the validation php file
include "Validation.php";

//create an empty variable to hold $postal
$postal="";
$phone="";
$v="";
$postalMsg="";
$phoneMsg="";
//create an if statement to check if the form has been submitted
if(isset($_POST["submit"])) {
    $postal = filter_input(INPUT_POST, "user_postal");
    $phone = filter_input(INPUT_POST, "user_phone");
    $v = new Validation();
    $postalMsg = $v->checkPostal($postal);
    $phoneMsg = $v->checkPhone($phone);
}
?>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Kelly Ann McNamara | Web Apps 2 | Lab 5</title>
</head>
<body>
    <main id="main">
        <form action="#" method="post" id="form">
            <fieldset>
                <div class="form-field">
                    <label for="postal">Postal</label>
                    <input type="text" id="postal" name="user_postal" />
                </div>
                <div class="form-field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="user_phone">
                </div>
                <input type="submit" value="Press Me!" name="submit" />
            </fieldset>
        </form>
        <div><?php echo $postal ?><br /><?php echo $postalMsg ?><br /><br /><?php echo $phone ?><br /><?php echo $phoneMsg ?></div>
    </main>


</body>
</html>
