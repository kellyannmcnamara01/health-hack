<?php
include '../Common Views/Header.php';
include '../Common Views/sidebar.php';

$user_id = 1;
//create a new $cardioworkout object and set it's user id equal to that of the user logged in.

require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($user_id);


//grab the database connection.

require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDb();

//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

//now, if the load button is clicked, we have to load that specific cardio workout and it's details.

if (isset($_POST['load_cardio'])) {
    //grab our id of the cardio workout that was selected from the drop-down menu

    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');
    //now assign this value to a new cardio workout object

    $selected_Cardio_Workout = new cardioworkout();
    $selected_Cardio_Workout->setUserId($user_id);
    $selected_Cardio_Workout->setId($cardio_id);

    //running a query to get all of the information for the cardio workout that was selected.
    $get_1_Cardio   = new cardioworkoutDAO();
    $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);
}
if (isset($_POST['save_workout'])) {

    //re-capture the form input so it still displays if the user clicks this button.
    //we also do this in case the user submits the workout without first loading workout details, which is acceptable.
    $cardio_id = filter_input(INPUT_POST, 'cardio_workout');
    //now assign this value to a new cardio workout object

    $selected_Cardio_Workout = new cardioworkout();
    $selected_Cardio_Workout->setUserId($user_id);
    $selected_Cardio_Workout->setId($cardio_id);

    //running a query to get all of the information for the cardio workout that was selected.
    $get_1_Cardio = new cardioworkoutDAO();
    $cardio_Workout = $get_1_Cardio->get1CardioWorkout($conn, $selected_Cardio_Workout);

    //grab our values to be inserted into completed cardio workouts.
    $distance = filter_input(INPUT_POST, 'cardio_distance');
    $hours = filter_input(INPUT_POST, 'hours');
    $minutes = filter_input(INPUT_POST, 'minutes');
    $seconds = filter_input(INPUT_POST, 'seconds');

    //do validation.
    require_once '../Models/Validation.php';
    $v = new Validation();

    if ($cardio_id == 0) {
        $cardio_workout_error = "Select a workout!";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "Enter distance!";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "Enter time!";
    }
    //testing if everything validates to true, and if so, do the steps required to insert into the database.
    if ($cardio_id != 0 && $v->testZero($distance) == true && ($v->testZero($hours) == true || $v->testZero($minutes) == true || $v->testZero($seconds) == true)) {

        //grab our function file to format the time
        require_once '../functions/time_format_function.php';
        $cardio_time = timeFormat($hours, $minutes, $seconds);

        //now create a new completed cardio workout object.
        require_once '../Models/completedCardioWorkout.php';
        $completed_Cardio = new completedCardioWorkout();

        //set the properties of this completed cardio workout equal to the form values.
        $completed_Cardio->setCardioId($cardio_id);
        $completed_Cardio->setDistance($distance);
        $completed_Cardio->setTime($cardio_time);

        //create a new DAO object, and call the method to insert, passing in our connection and completed cardio object

        $complete = new cardioworkoutDAO();
        $complete->insertCompletedCardio($conn, $completed_Cardio);

        //set all form values back to zero.
        $distance = 0;
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        $success_message = "Workout logged!";

    }
}

?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
<div class="container">
        <form action="#" method="post">
            <div class="col-md-12 big-spacing">
            <h1 class="red">Begin a Cardio workout</h1>
                <p>Here, you can select a cardio workout you created, and log it to your profile!</p>
                <p class="badge badge-success"><?php if(isset($success_message)){echo $success_message;}?></p>
            </div>

            <h3 class=" offset-md-1 spacing">Load your workout here</h3>
            <div class="form-field big-spacing col-md9 offset-md-0">
                <h2 class="spacing">Select a cardio workout</h2>
                <select  name="cardio_workout" class="form-control col-md-9 col-sm-9 col-xs-9">
                                    <option value="0">--Select--</option>
                                    <?php
                                    foreach ($cardio_workouts as $cardio):
                                        ?>
                                        <option <?php
                                        if (isset($cardio_Workout) && $cardio_Workout['name'] == $cardio['name']) {
                                            echo 'selected';
                                        }
                                        ?> ) value="<?php
                                        echo $cardio['cardio_id'];
                                        ?>"><?php
                                            echo $cardio['name'];
                                            ?></option>
                                        <?php
                                    endforeach;
                                    ?>
                                </select><span class="badge badge-warning"><?php if (isset($cardio_workout_error)){ echo $cardio_workout_error;}?></span>
                    </div>

            <div class="form-field big-spacing">
                    <input  type="submit" name="load_cardio" value="Load Details" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3 "/>
            </div>
            <h3 class="offset-md-1 spacing">Log your workout here </h3>



                    <h4 class="text-left offset-md-4"><?php
                        if (isset($cardio_Workout)) {
                            echo $cardio_Workout['name'];
                        }
                        ?></h4>

                <div class="row big-spacing">
                    <h4 class=" text-left col-md-4 offset-md-0">Your goal Time: <?php
                            if (isset($cardio_Workout)) {
                                echo   $cardio_Workout['goal_time'];
                            }
                            ?></h4>
                    <h4 class="text-left col-md-6 offset-md-0"">Your goal Distance in KM:<?php
                            if (isset($cardio_Workout)) {
                                echo  $cardio_Workout['goal_distance'];
                            }
                            ?></h4>
                </div>


            <form action="#" method="post">
                <div class="form-field big-spacing col-md-9 offset-md-0">
                    <h2 class="spacing">Enter the distance travelled.</h2>
                    <select class="textInput col-md-3 col-sm-3 col-xs-3" name="cardio_distance">
                        <option value="0">Total Distance</option>
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
                    </select><span class="badge badge-warning"><?php if (isset($distance_error)){ echo $distance_error;}?></span>
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
                    </select><span class="badge badge-warning"><?php if(isset($time_error)){echo $time_error;}?></span>
                </div>


                <div class="form-field big-spacing">
                        <input type="hidden" name="cardio_workouts_id""/>
                        <input type="submit" value="Save Workout" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" name="save_workout"/>
                </div>
            <div class="form-group">
            <input type="hidden" value="<?php if (isset($cardio_id)) {echo $cardio_id;}?>"
            </div>
            </form>

    </div>
    </div>
    </main>
<?php
include '../Common Views/Footer.php';
?>