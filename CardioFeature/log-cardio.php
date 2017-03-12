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
        $cardio_workout_error = "You must select a cardio workout to log";
    }
    if ($v->testZero($distance) == false) {
        $distance_error = "You must enter a distance for this workout";
    }
    if ($v->testZero($hours) == false && $v->testZero($minutes) == false && $v->testZero($seconds) == false) {
        $time_error = "You must enter a time for this workout";
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

        $success_message = "Your workout has been logged to the system!";
        header("refresh:5; url=health-hack/CardioFeature/Cardio.php");

    }
}

?>
    <div id="main-content" class="col-md-6 col-sm-12 col-12 row">

        <form class="form-horizontal" action="#" method="post">

            <div class="row">
                <div class="col-lg-10">
                    <h2>Begin a Cardio workout</h2>
                    <p>Select one of your custom cardio workouts below in the drop down menu and when you are done, log the total distance travelled and total time.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-lg-4" for="select_cardio">Select your Cardio Workout:</label>
                            <div class="col-lg-6">
                                <select name="cardio_workout" class="col-lg-6">
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
                                </select><span class="text-danger"><?php if (isset($cardio_workout_error)){ echo $cardio_workout_error;}?></span>
                            </div>
                        </div>
                    </div>
                    <input type="submit" name="load_cardio" value="Load Cardio Workout Details" class="btn btn-success "/>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-10 text-center">
                    <h2><?php
                        if (isset($cardio_Workout)) {
                            echo $cardio_Workout['name'];
                        }
                        ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="text-center">Your goal Time: <span><?php
                            if (isset($cardio_Workout)) {
                                echo $cardio_Workout['goal_time'];
                            }
                            ?></span></h3>
                </div>
                <div class="col-lg-6">
                    <h3 class="text-center">Your goal Distance: <span><?php
                            if (isset($cardio_Workout)) {
                                echo $cardio_Workout['goal_distance'];
                            }
                            ?> km</span></h3>

                </div>
            </div>
            <form action="#" method="post">
                <div class="form-group">
                    <label class="control-label col-lg-2" for="cardio_distance"> Total Distance:</label>
                    <select name="cardio_distance">
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
                <div class="form-group">
                    <label class="control-label col-lg-2" for="cardio_time">Total Time:</label>
                    <select name="hours">
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
                    <select name="minutes">
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
                    <select name="seconds">
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

                <div class="row">
                    <div class="col-lg-9 text-right">
                        <input type="hidden" name="cardio_workouts_id""/>
                        <input type="submit" value="Save Workout" class=" btn btn-success " name="save_workout"/>
                    </div>
                </div>
                <div>

                </div>
            <input type="hidden" value="<?php if (isset($cardio_id)) {echo $cardio_id;}?>"
            </form>
            <p class="text-success"><?php if(isset($success_message)){echo $success_message;}?></p>

    </div>
    </main>
<?php
include '../Common Views/Footer.php';
?>