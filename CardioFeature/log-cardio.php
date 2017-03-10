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

?>
<div class="container">
    <form class="form-horizontal" action="load_cardio_workout.php" method="post">

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
                <button type="submit" class="btn btn-success ">Load Workout</button>
            </div>
        </div>
    </form>

</div>



<?php
include '../Common Views/Footer.php';
?>