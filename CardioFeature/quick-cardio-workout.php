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
        $type_error = "Name this workout.";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time";
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
        $success_message = "Workout saved!";

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

            <div class="col-md-12 big-spacing">
                <h1 class="red">Quick Cardio Workout:</h1>
                <p class="badge badge-success"><?php if(isset($success_message)){echo $success_message;}?></p>

                <p>Here, you can quickly record a cardio workout without having to load a previously created cardio workout!</p>
            </div>
                <div class="form-field big-spacing col-md-6 offset-md-0 ">
                    <h2 class="spacing">Name the Cardio Workout:</h2>
                        <input placeholder="Name of Cardio Workout" type="text" class="textInput" name="type"/><span class=" badge badge-warning"><?php if (isset($type_error)){echo $type_error;}?></span>
                 </div>

        <div class="form-field big-spacing  col-md-9 offset-md-0 ">
            <h2 class="spacing">Enter the distance travelled:</h2>

            <select class="textInput  col-md-3 col-sm-3 col-xs-3" name="cardio_distance">
                    <option  value="0">Total Distance</option>
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
                </select><span class=" badge badge-warning"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
            </div>
        <div class="form-field big-spacing offset-md-0">
            <h2 class="spacing">Enter the time it took to complete the workout:</h2>

            <select class="textInput col-md-2 col-sm-3 col-xs-1 offset-md-0" name="hours">
                    <option value="0">Hours</option>
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

                </select>
                <select class="textInput col-md-2 col-sm-3 col-xs-1 offset-md-1" name="minutes">
                    <option value="0">Minutes</option>
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
                </select>
                <select class="textInput select-box col-md-2 col-sm-3 col-xs-1 offset-md-1" name="seconds">
                    <option value="0">Seconds</option>
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
                </select><span class=" badge badge-warning"><?php if(isset($time_error)){echo $time_error;}?></span>
        </div>

            <div class="form-field big-spacing">
                    <input type="submit" value="Save Workout" class=" formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" name="save_workout"/>
            </div>
        </form>
</div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>
