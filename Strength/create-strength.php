<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 4:32 PM
 */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;

if (isset($_POST['submit_strength'])){

    //get the values
    $strength_name = filter_input(INPUT_POST,'strength_name');

    if (!isset($_POST['exercises'])) {
        $exercise_error = "You must enter exercises for the workout!";
    }
    else {
        $exercises = array($_POST['exercises']);
        $string = $exercises[0];
    }


    //validate the strength name

    require_once '../Models/Validation.php';
    $v = new Validation();
    if ($v->testName($strength_name) == false){
    $strength_error = "Provide a name for this workout!";
    }

    //if a workout name has been provided, and exercises for the workout have been provided, insert into the database.
    if ($v->testName($strength_name) == true && isset($_POST['exercises'])) {
        //create a connection
        require_once '../Models/Database.php';
        $db = new Database();
        $conn = $db->getDb();

        //create a new strength workout class and set its values.

        require_once '../Models/StrengthWorkout.php';
        $strength_workout = new StrengthWorkout();
        $strength_workout->setUserId($user_id);
        $strength_workout->setName($strength_name);

        //check if there is another strength workout that has the same name. If there is, provide an error message and do not proceed.
        require_once '../Models/StrengthWorkoutDAO.php';
        $sw = new StrengthWorkoutDAO();
        $list = $sw->verifyUniqueName($conn, $strength_workout);
        $namesList = array();
        foreach ($list as $key=>$value){
            array_push($namesList, $value[0]);
        }
        if (in_array($strength_name, $namesList)){
            $strength_error = "You must pick a unique workout name!";
        }
        else {

            //create a new strengthDAO class and insert into the database.
            require_once '../Models/StrengthWorkoutDAO.php';
            $sw = new StrengthWorkoutDAO();
            $sw->insertStrengthWorkout($conn, $strength_workout);


            //now, let's add the exercises that were stored in our list.

            foreach ($string as $key => $value) {
                $sw->insertStrengthExercises($conn, $value, $strength_workout);
            }
            $success_message = "Workout created!";
            $strength_name = "";
        }
    }
}
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <div class="col-md-12 big-spacing">
            <h1 class="red">Create a Strength Workout</h1>
            <p>Here, you can create and store your own custom strength workouts!</p>
        </div>
        <form action="#" method="post">
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">Name of Strength Workout</h2>
                <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>

                <input placeholder="Provide Name for Strength Workout" <?php if (isset($strength_name)){ echo "value='" . $strength_name ."'";}?> type="text" class="form-control col-md-9 col-sm-9 col-xs-9" name="strength_name"/>
            </div><span class="badge badge-warning"><?php if (isset($strength_error)){ echo $strength_error;}?></span>
            <div class="form-field big-spacing col-md-6 offset-md-0">
                <h2 class="spacing">Exercises</h2>
                <input placeholder="Add an exercise and hit ADD" type="text" class="form-control" id="ex_name" name="exercise_name"/>
                <button type="button" id="add_ex" class="btn btn-primary">Add exercise</button><span class="badge badge-warning exercise_error "></span>
            </div>
            <h4>Your exercises</h4>
            <span class="badge badge-warning"><?php if (isset($exercise_error)){ echo $exercise_error;}?></span>
            <ul id="ex_list">

            </ul>
<input class="formSubmit col-md-3 col-sm-6 col-xs-1 text-center offset-md-5 offset-sm-3" type="submit" name="submit_strength"/>
        </form>
    </div>
</div>
</main>
<?php
require_once '../Common Views/Footer.php';
?>
