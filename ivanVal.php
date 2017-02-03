<?php
    //$value - email to validate
    //returns: true if valid, false - if not.
    function validateEmail($value) 
    {
        return (filter_var($value, FILTER_VALIDATE_EMAIL) === false) ? false : true;
    }

    //$nameAtr - value of name attribute
    //returns: true if radio button is selected, false - if not.
    function radioChecked($nameAtr)
    {
        return (isset($_POST[$nameAtr]) === true) ? true : false;
    }

    $email = '';
    $color = '';
    if (isset($_POST['send']))
    {
        var_dump($_POST);
        echo '<br />';
        $email = $_POST['email'];
        //$color = $_POST['color'];
        echo 'email validation: ' . ((validateEmail($email) === true) ? 'valid' : 'invalid');
        echo '<br />';
        echo 'radio selection: ' . ((radioChecked('color') === true) ? 'selected' : 'not selected');
    }


?>
<form action="" method="post">
    <div>
        <input type="text" name="email" value="<?php echo $email; ?>">
    </div>
    <div>
        <input type="radio" name="color" value="Green">Green<br/ >
        <input type="radio" name="color" value="Red">Red<br/ >
        <input type="radio" name="color" value="Blue">Blue<br/ >
    </div>
    <input type="submit" name="send" value="Send">
</form>