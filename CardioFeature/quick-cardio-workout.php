<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-11
 * Time: 6:10 PM
 */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

//manually setting the user
$user_id = 1;
if (isset($_POST['save_workout'])) {

    //grab the variables from the form
    $type = filter_input(INPUT_POST, 'type');
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');


    //validate them
    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($type) == false) {
        $type_error = "You must enter what type of cardio workout this was.";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "You must enter in a distance for this workout";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "You must enter a time for the workout";
    }
    if ($v->testName($type) == true && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //function to concatenate to appropriate time format

        require_once '../functions/time_format_function.php';
        $time = timeFormat($hours, $minutes, $seconds);


        //insert into database and provide a succcess message.

        //grab the database class.

        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDb();

        //grab our quick workout class, create an object, set its properties

        require_once '../Models/quickworkout.php';
        $q = new quickworkout();
        $q->setUserId($user_id);
        $q->setTime($time);
        $q->setDistance($distance);
        $q->setType($type);

        //create a new DAO obect, call its method to insert into quick workouts, pass in our db connnection and quick workout object.
        require_once '../Models/cardioworkoutDAO.php';
        $quick_cardio = new cardioworkoutDAO();
        $quick_cardio->insertQuickCardio($conn, $q);


        //display success message
        $success_message = "You cardio workout was saved!";

        //re-set all values

        $type = "";
        $distance = 0;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;
    }


}
?>
<div id="main-content" class="col-md-9 col-sm-9 col-xs-9 row">
<div class="container">
    <form action="#" method="post">

            <div class="col-md-12">
                <h2 class="text-center">Quick Cardio Workout:</h2>
                <p>Here, you can quickly record a cardio workout without having to load a previously created cardio workout!</p>
            </div>
        <p>&nbsp</p>
                <div class="form-group col-md-9">
                        <label for="select_cardio">Type of Cardio:</label>
                        <input type="text" class="form-control" name="type"/><span class="text-danger"><?php if (isset($type_error)){echo $type_error;}?></span>
                 </div>
        <div class="form-group col-md-9 ">
                <label for="cardio_distance"> Total Distance:</label>
                <select class="form-control" name="cardio_distance">
                    <?php
                    foreach (range(0, 100, 0.5) as $i):
                        ?>
                        <option <?php
                        if (isset($distance) && $distance == $i) {
                            echo 'selected';
                        }
                        ?> value="<?php
                        echo $i;
                        ?>"><?php
                            echo $i;
                            ?></option>
                        <?php
                    endforeach;
                    ?>
                </select><span>km</span><span class="text-danger"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
            </div>
        <p>&nbsp</p>

        <div class="row">
                <label for="cardio_time">Total Time:</label>
                <select class="form-control col-md-1 col-sm-1" name="hours">
                    <?php
                    foreach (range(0, 10, 1) as $i):
                        ?>
                        <option <?php
                        if (isset($hours) && $hours == $i) {
                            echo 'selected';
                        }
                        ?> value="<?php
                        echo $i;
                        ?>"><?php
                            echo $i;
                            ?></option>
                        <?php
                    endforeach;
                    ?>
                </select><span>Hours</span>
                <select class="form-control col-md-1 col-sm-1" name="minutes">
                    <?php
                    foreach (range(0, 59, 1) as $i):
                        ?>
                        <option <?php
                        if (isset($minutes) && $minutes == $i) {
                            echo 'selected';
                        }
                        ?> value="<?php
                        echo $i;
                        ?>"><?php
                            echo $i;
                            ?></option>
                        <?php
                    endforeach;
                    ?>
                </select><span>Minutes</span>
                <select class="form-control col-md-1 col-sm-1" name="seconds">
                    <?php
                    foreach (range(0, 59, 1) as $i):
                        ?>
                        <option <?php
                        if (isset($seconds) && $seconds == $i) {
                            echo 'selected';
                        }
                        ?> value="<?php
                        echo $i;
                        ?>"><?php
                            echo $i;
                            ?></option>
                        <?php
                    endforeach;
                    ?>
                </select><span>seconds</span><span class="text-danger"><?php if(isset($time_error)){echo $time_error;}?></span>
            </div>
        <p>&nbsp</p>

            <div class="form-group text-center">
                    <input type="submit" value="Save Workout" class=" form-control btn btn-success col-md-3" name="save_workout"/>
            </div>
        </form>
        <p class="text-success"><?php if(isset($success_message)){echo $success_message;}?></p>
</div>
</div>
</main>
