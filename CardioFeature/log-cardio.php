<?php
include '../Common Views/Header.php';
include '../Common Views/sidebar.php';

$user_id = 1;
//create a new $cardioworkout object and set it's user id equal to that of the user logged in.

require_once '../Models/cardioworkout.php';
$c= new cardioworkout();
$c->setUserId($user_id);


//grab the database connection.

require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDb();

//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

//now, if the load button is clicked, we have to load that specific cardio workout and it's details.


?>
<div class="container">
    <form class="form-horizontal" action="#" method="post">

        <div class="row">
            <div class="col-lg-10">
                <h1>Begin a Cardio workout</h1>
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
                                <option>--Select Below--</option>
                                <?php foreach ($cardio_workouts as $cardio):?>
                                    <option value="<?php echo $cardio['id']?>"><?php echo $cardio['name']?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="submit" name="load_cardio" value="Load Workout" class="btn btn-success "/>
            </div>
        </div>
    </form>

</div>
    <div class="row">
        <div class="col-lg-10 text-center">
            <h1>Cardio Workout:</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <h2 class="text-center">Your goal Time: <span></span></h2>
        </div>
        <div class="col-lg-6">
            <h2 class="text-center">Your goal Distance: <span>km</span></h2>

        </div>
    </div>
    <form action="#" method="post">
            <div class="form-group">
                <label class="control-label col-lg-2" for="cardio_distance"> Total Distance:</label>
                    <select name="cardio_distance">
                    <?php foreach (range(0, 100, 0.5) as $i) :?>
                        <option <?php if(isset($cardio_distance) && $cardio_distance == $i){echo 'selected';}?> value="<?php echo  $i?>"><?php echo $i?></option>
                    <?php endforeach;?>
                    </select><span>km</span>
            </div>
            <div class="form-group">
                <label class="control-label col-lg-2" for="cardio_time">Total Time:</label>
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

        <div class="row">
            <div class="col-lg-9 text-right">
                <input type="hidden" name="cardio_workouts_id""/>
                <input type="submit" value="Save Workout" class=" btn btn-success " name="save_workout"/>
            </div>
        </div>
        <div>

        </div>

    </form>



<?php
include '../Common Views/Footer.php';
?>