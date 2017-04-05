<?php
$user_id = 1;
//create a new $cardioworkout object and set it's user id equal to that of the user logged in.

require_once '../Models/cardioworkout.php';
$c = new cardioworkout();
$c->setUserId($user_id);


//grab the database connection.

require_once '../Models/Database.php';
$db   = new Database();
$conn = $db->getDbFromAWS();

//create a new cardioWorkoutDAO object and pass in our cardio object and database connection.
require_once '../Models/cardioworkoutDAO.php';
$get_Cardio      = new cardioworkoutDAO();
$cardio_workouts = $get_Cardio->getCardioWorkouts($conn, $c);

//grabbing strength workouts

//grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($user_id);

//grab all of our strength workouts passing in the connection and strength workout object
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);


if (isset($_POST['routine_yes']) || isset($_POST['routine_no'])){

    //create a new routine object

    //create a routine DAO object and use it to insert into db

    //if they would like to make this the active routine, query for routines where active is set to yes, and update to no, then insert our routine with active 'yes'

}

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <form action="#" method="post">
        <div class="col-md-12 big-spacing">
            <h1 class="red">Set a Routine</h1>
            <p>Here, you can create a routine by selecting a cardio and strength workout for each day of the week. Your routine will appear in your calendar so that you can easily schedule and complete workouts!</p>
            <div class="row">
                <div class="col-md-3">
                    <h2>Monday</h2>
                    <select name="monday_cardio" class="form-control">
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
                    </select>
                    <select name="monday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <h2>Tuesday</h2>
                    <select name="tuesday_cardio" class="form-control">
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
                    </select>
                    <select name="tuesday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <h2>Wednesday</h2>
                    <select name="wednesday_cardio" class="form-control">
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
                    </select>
                    <select name="wednesday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <h2>Thursday</h2>
                    <select name="thursday_cardio" class="form-control">
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
                    </select>
                    <select name="thursday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h2>Friday</h2>
                    <select name="friday_cardio" class="form-control">
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
                    </select>
                    <select name="friday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <h2>Saturday</h2>
                    <select name="saturday_cardio" class="form-control">
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
                    </select>
                    <select name="saturday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <h2>Sunday</h2>
                    <select name="sunday_cardio" class="form-control">
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
                    </select>
                    <select name="sunday_strength" class="form-control">
                        <option value="0">--Select--</option>
                        <?php
                        foreach ($strength_workouts as $strength):
                            ?>
                            <option <?php
                            if (isset($strength_Workout)) {
                                foreach ($strength_Workout as $key){
                                    if ($key['strength_id'] == $strength['strength_id']){
                                        echo 'selected ';
                                    }

                                }
                            }
                            ?>  value="<?php
                            echo $strength['strength_id'];
                            ?>"><?php
                                echo $strength['strength_workout_name'];
                                ?></option>
                            <?php
                        endforeach;
                        ?>
                    </select>
                </div>
            </div>
        </div>
            <!-- Modal attempt
            <button data-target="#set_active" data-toggle="modal"   type="button" name="save_routine" class="formSubmit">Save Routine</button>
            <div id="set_active" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times</button>
                            <h4 class="modal-header">Set as active Routine?</h4>
                        </div>
                        <div class="modal-body">
                            <p>Choose yes for this routine to appear in your calendar</p>
                        </div>
                        <div class="modal-footer">
                            <input  type="submit" name="routine_yes" value="Yes" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
                            <input  type="submit" name="routine_no" value="No" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
                        </div>
                    </div>
                </div>
            </div>-->
            <div class="spacing">
                <h2 class="text-center">Routine Options</h2>
                <p class="spacing text-center">Click yes to make this routine your active routine in your calendar</p>
            <input  type="submit" name="routine_yes" value="Yes" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
            <input  type="submit" name="routine_no" value="No" class="formSubmit col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
            </div>
        </form>
    </div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>