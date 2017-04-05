<?php
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;
if (isset($_POST['submit_cardio'])){
    //grab inputs from previous form

    $cardio_name = filter_input(INPUT_POST, 'cardio_name');
    $cardio_type = filter_input(INPUT_POST, 'cardio_type');
    $cardio_distance = filter_input(INPUT_POST, 'cardio_distance');
    $cardio_hours =  filter_input(INPUT_POST, 'hours');
    $cardio_minutes = filter_input(INPUT_POST, 'minutes');
    $cardio_seconds = filter_input(INPUT_POST, 'seconds');


//now let's validate

    require_once '../Models/Validation.php';
    $v = new Validation();

    if ($v->testName($cardio_name) == false) {
        $name_error = "Name workout!";
    }
    if ($v->testName($cardio_type == false)){
        $type_error = "Specify type!";
    }
    if ($v->testZero($cardio_distance) == false){
        $distance_error = "Enter goal distance!";
    }
    if ($v->testZero($cardio_hours) == false && $v->testZero($cardio_minutes) == false && $v->testZero($cardio_seconds) == false){
        $time_error = "Enter goal time!!";
    }

    if ($v->testName($cardio_name) == true && $v->testName($cardio_type == true && $v->testZero($cardio_distance) == true && ($v->testZero($cardio_hours) == true || $v->testZero($cardio_minutes) == true || $v->testZero($cardio_seconds) == true))){
        //insert a function to change the time format

        require_once '../functions/time_format_function.php';

        $cardio_time = timeFormat($cardio_hours, $cardio_minutes, $cardio_seconds);
        //now we create a new cardioworkout class and set the values equal to our form values

        require_once '../Models/cardioworkout.php';
        $c = new cardioworkout();

        $c->setName($cardio_name);
        $c->setUserId($user_id);
        $c->setGoalDistance($cardio_distance);
        $c->setGoalTime($cardio_time);
        $c->setUserId($user_id);

        //now let's get the database connection and create a new object

        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDbFromAWS();

    //now we grab our DAO object, call the insert method, passing in our db connection and our cardio workout object.

    require_once '../Models/cardioworkoutDAO.php';
    $insert_C = new cardioworkoutDAO();
    $insert_C->insertCardio($conn, $c);

        $success_message = "Workout created!!";

        //set all form values back to zero
        $cardio_name = "";
        $cardio_type = "";
        $cardio_distance = "";
        $cardio_hours =  "";
        $cardio_minutes = "";
        $cardio_seconds = "" ;


    }


    }




?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
<div class="container">
    <div class="col-md-12 big-spacing">
        <h1 class="red">Create a Cardio Workout</h1>
        <p>Here, you can create and store your own custom cardio workouts!</p>
        <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>
    </div>

    <form action="#" method="post">
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">Name the Cardio Workout</h2>
                <input placeholder="Name of Cardio Workout" <?php if (isset($cardio_name)){ echo "value='" . $cardio_name ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="cardio_name"/><span class="badge badge-warning"><?php if (isset($name_error)){ echo $name_error;}?></span>
            </div>
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">What type of Cardio is this workout?</h2>
                    <input placeholder="Run, walk, bike etc" <?php if (isset($cardio_type)){ echo "value='" . $cardio_type ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="cardio_type"/><span class="badge badge-warning"><?php if (isset($type_error)){ echo $type_error;}?></span>
            </div>

                <div class="form-field big-spacing col-md-9 offset-md-0">
                    <h2 class="spacing">Enter a Goal for the Distance of your workout</h2>
                    <select class="textInput col-md-3 col-sm-3 col-xs-1" name="cardio_distance">
                        <option value="0">Goal Distance</option>
                        <?php foreach (range(0, 100, 0.5) as $i) :?>
                        <option <?php if(isset($cardio_distance) && $cardio_distance == $i){echo 'selected';}?> value="<?php echo  $i?>"><?php echo $i?></option>
                        <?php endforeach;?>
                    </select><span><span class="badge badge-warning"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
                 </div>
        <div class="form-field big-spacing offset-md-0">
            <h2 class="spacing">Enter your goal for the time to complete this workout:</h2>
            <select class="textInput col-md-2 col-sm-3 col-xs-1 offset-md-0" name="hours">
                <option value="0">Hours</option>
                      <?php foreach (range(0, 10, 1) as $i) :?>
                        <option <?php if(isset($cardio_hours) && $cardio_hours == $i){echo 'selected';}?> value="<?php echo $i?>"><?php echo $i?></option>
                      <?php endforeach ; ?>
                    </select>
                    <select class="textInput col-md-2 col-sm-3 col-xs-1 offset-md-1" name="minutes">
                        <option value="0">Minutes</option>
                    <?php foreach (range(0, 59, 1) as $i) :?>
                      <option <?php if(isset($cardio_minutes) && $cardio_minutes == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php endforeach ;?>
                  </select>
                    <select class="textInput col-md-2 col-sm-3 col-xs-1 offset-md-1" name="seconds">
                        <option value="0">Seconds</option>
                      <?php foreach (range(0, 59, 1) as $i) :?>
                        <option <?php if(isset($cardio_seconds) && $cardio_seconds == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
                      <?php endforeach ;?>
                    </select><span class="badge badge-warning"><?php if (isset($time_error)){echo $time_error;}?></span>
                </div>
                <div class="form-field big spacing">
                    <input class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" type="submit" name="submit_cardio"/>
                </div>
    </form>
</div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>
