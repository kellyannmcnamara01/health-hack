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
        $name_error = "You must enter a name";
    }
    if ($v->testName($cardio_type == false)){
        $type_error = "You must enter a type of cardio";
    }
    if ($v->testZero($cardio_distance) == false){
        $distance_error = "You must enter a goal for a distance";
    }
    if ($v->testZero($cardio_hours) == false && $v->testZero($cardio_minutes) == false && $v->testZero($cardio_seconds) == false){
        $time_error = "You must enter a goal for your time!";
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
        $conn = $db->getDb();

    //now we grab our DAO object, call the insert method, passing in our db connection and our cardio workout object.

    require_once '../Models/cardioworkoutDAO.php';
    $insert_C = new cardioworkoutDAO();
    $insert_C->insertCardio($conn, $c);

        $success_message = "Your workout has been saved to the system!";

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

    <h2>Create a Cardio Workout</h2>
    <p>Here, you can create and store your own custom cardio workouts!</p>

    <form action="#" method="post">
        <div>
            <div>
                <label for="name_cardio">Name of Cardio Workout:</label><span class="text-danger"><?php if (isset($name_error)){ echo $name_error;}?></span>
                <div>
                    <input <?php if (isset($cardio_name)){ echo "value='" . $cardio_name ."'";}?> type="text" class="form-control" name="cardio_name"/>
                </div>
            </div>
        </div>
        <div>
            <div>
                <label for="type_cardio">Type of Cardio Workout</label><span class="text-danger"><?php if (isset($type_error)){ echo $type_error;}?></span>
                <div>
                    <input <?php if (isset($cardio_type)){ echo "value='" . $cardio_type ."'";}?> type="text" class="form-control" name="cardio_type"/>
                </div>
            </div>
        </div>
        <div>
            <div>
                <label  for="goal_distance">Distance Goal:</label><span class="text-danger"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
                <div>
                    <select name="cardio_distance">
                        <?php foreach (range(0, 100, 0.5) as $i) :?>
                        <option <?php if(isset($cardio_distance) && $cardio_distance == $i){echo 'selected';}?> value="<?php echo  $i?>"><?php echo $i?></option>
                        <?php endforeach;?>
                    </select><span>km</span>
                </div>
                <label for="goal_time">Time Goal:</label><span class="text-danger"><?php if (isset($time_error)){echo $time_error;}?></span>
                <div>
                    <select name="hours">
                      <?php foreach (range(0, 10, 1) as $i) :?>
                        <option <?php if(isset($cardio_hours) && $cardio_hours == $i){echo 'selected';}?> value="<?php echo $i?>"><?php echo $i?></option>
                      <?php endforeach ; ?>
                    </select><span>Hours</span>
                    <select name="minutes">
                    <?php foreach (range(0, 59, 1) as $i) :?>
                      <option <?php if(isset($cardio_minutes) && $cardio_minutes == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php endforeach ;?>
                  </select><span>Minutes</span>
                    <select name="seconds">
                      <?php foreach (range(0, 59, 1) as $i) :?>
                        <option <?php if(isset($cardio_seconds) && $cardio_seconds == $i){echo 'selected';}?> value="<?php echo $i; ?>"><?php echo $i?></option>
                      <?php endforeach ;?>
                    </select><span>seconds</span>


                </div>
            </div>
            <div>
                <div>
                    <button type="submit" name="submit_cardio">Save Workout</button>
                </div>
            </div>
    </form>
    <div>
        <p class="text-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>

    </div>

</div>
<?php
require_once '../Common Views/Footer.php';
?>
