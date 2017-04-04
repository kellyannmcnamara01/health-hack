<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-27
 * Time: 3:29 PM
 */

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
//test change
$user_id = 1;

//grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

require_once '../Models/StrengthWorkout.php';
$sw = new StrengthWorkout();
$sw->setUserId($user_id);

//create the db connection
require_once '../Models/Database.php';
$db = new Database();
$conn = $db->getDb();

//grab all of our strength workouts passing in the connection and strength workout object
require_once '../Models/StrengthWorkoutDAO.php';
$get_strength = new StrengthWorkoutDAO();
$strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);



//here, a workout has been selected.

if (isset($_POST['load_strength'])){
    $strength_id = filter_input(INPUT_POST,'strength_workout');
    //validate it to make sure it's not zero.

    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testZero($strength_id) == false){
        $strength_workout_error = "You must select a strength workout!";
    }
    else {
        //now create the strength workout object

        $selected_Strength_Workout = new StrengthWorkout();
        $selected_Strength_Workout->setUserId($user_id);
        $selected_Strength_Workout->setId($strength_id);

        //now let's get all the exercises associated with that strength workout.

        $get_Strength = new StrengthWorkoutDAO();
        $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);



    }
}
if (isset($_POST['save_strength'])){
    //re-capture the form so it still displays if the user presses this button

    //grab all the strength workouts associated with the id, and store it for access in a drop down list.
//create a new strength workout and set it's id equal to that of the user signed in.

    require_once '../Models/StrengthWorkout.php';
    $sw = new StrengthWorkout();
    $sw->setUserId($user_id);

//create the db connection
    require_once '../Models/Database.php';
    $db = new Database();
    $conn = $db->getDb();
$strength_id = filter_input(INPUT_POST,'strength_workout');
//validate it to make sure it's not zero.

require_once '../Models/Validation.php';
$v = new Validation();
if ($v->testZero($strength_id) == false){
    $strength_workout_error = "You must select a strength workout!";
}
else {
    //now create the strength workout object

    $selected_Strength_Workout = new StrengthWorkout();
    $selected_Strength_Workout->setUserId($user_id);
    $selected_Strength_Workout->setId($strength_id);

    //now let's get all the exercises associated with that strength workout.

    $get_Strength = new StrengthWorkoutDAO();
    $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);
}

//grab all of our strength workouts passing in the connection and strength workout object
    require_once '../Models/StrengthWorkoutDAO.php';
    $get_strength = new StrengthWorkoutDAO();
    $strength_workouts = $get_strength->getStrengthWorkouts($conn, $sw);

    $completed_exercise_id = array($_POST['exercise_id'])[0];
    $completed_strength_id = array($_POST['strength_id'])[0];
    $exercise_name = array($_POST['exercise_name'])[0];
    $weight = array($_POST['weight'])[0];
    $set_1 = array($_POST['set_1'])[0];
    $set_2 = array ($_POST['set_2'])[0];
    $set_3 = array($_POST['set_3'])[0];

    for ($i = 0; $i < count($completed_exercise_id); $i++){
        $query = "INSERT INTO COMPLETED_STRENGTH_EXERCISES 
        (exercise_id, strength_id, exercise_name, weight, set_1, set_2, set_3)
        VALUES (:completed_exercise_id, :completed_strength_id, :exercise_name, :weight,:set_1, :set_2, :set_3 )";
        $statement= $conn->prepare($query);
        $statement->bindValue(':completed_exercise_id', $completed_exercise_id[$i]);
        $statement->bindValue(':completed_strength_id', $completed_strength_id[$i]);
        $statement->bindValue('exercise_name', $exercise_name[$i]);
        $statement->bindValue(':weight', $weight[$i]);
        $statement->bindValue(':set_1', $set_1[$i]);
        $statement->bindValue(':set_2', $set_2[$i]);
        $statement->bindValue(':set_3', $set_3[$i]);
        $statement->execute();
        $statement->closeCursor();
    }

    //now that we've grabbed all the elements we need, we must insert them into the completed strength workouts table in a foreach loop

}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <form action="#" method="post">
        <div class="col-md-12 big-spacing">
            <h1 class="red">Log a Strength Workout</h1>
            <p>Here, you can select a strength workout you created, and log it to your profile!</p>
            <p class="badge badge-success"><?php if(isset($success_message)){echo $success_message;}?></p>
        </div>

        <h3 class=" offset-md-1 spacing">Load your workout here</h3>
        <div class="form-field big-spacing col-md9 offset-md-0">
            <h2 class="spacing">Select a strength workout</h2>
            <select  name="strength_workout" class="form-control col-md-9 col-sm-9 col-xs-9">
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
            </select><span class="badge badge-warning"><?php if (isset($strength_workout_error)){ echo $strength_workout_error;}?></span>
        </div>

        <div class="form-field big-spacing">
            <input  type="submit" name="load_strength" value="Load Details" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3 "/>
        </div>
        <h3 class="offset-md-1 spacing">Log your workout here </h3>
            <div class="table-responsive big-spacing">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Exercise</th>
                        <th>Weight</th>
                        <th>Set 1</th>
                        <th>Set 2</th>
                        <th>Set 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (isset($strength_Workout)){
                        require_once 'exercise-form.php';
                    }?>


                    </tbody>
                </table>
            </div>
            <div class="form-field big-spacing">
              <input  type="submit" name="save_strength" value="Save Workout" class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3    "/>
            </div>
        </form>
    </div>
    </div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>

