<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-27
 * Time: 3:29 PM
 */

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

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

        $get_1_Strength = new StrengthWorkoutDAO();
        $strength_Workout = $get_strength->get1StrengthWorkout($conn, $selected_Strength_Workout);
       /* echo "<li>" .  $strength_Workout[0]['strength_id'] .  "</li>" ;
        echo  "<li>" . $strength_Workout[0]['user_id'].  "</li>" ;
        echo  "<li>" . $strength_Workout[0]['strength_workout_name'].  "</li>" ;
        echo  "<li>" . $strength_Workout[0]['exercise_id'].  "</li>" ;
        echo  "<li>" . $strength_Workout[0]['exercise_name'].  "</li>" ;
        echo  "<li>" . $strength_Workout[0]['strength_workout_id'].  "</li>" ;
        echo "<li>" .  $strength_Workout[1]['strength_id'] .  "</li>" ;
        echo  "<li>" . $strength_Workout[1]['user_id'].  "</li>" ;
        echo  "<li>" . $strength_Workout[1]['strength_workout_name'].  "</li>" ;
        echo  "<li>" . $strength_Workout[1]['exercise_id'].  "</li>" ;
        echo  "<li>" . $strength_Workout[1]['exercise_name'].  "</li>" ;
        echo  "<li>" . $strength_Workout[1]['strength_workout_id'].  "</li>" ;*/
      //  print_r($strength_Workout);
        /*for ($i = 0; $i < count($strength_Workout); $i++){
            echo $strength_Workout[$i]['exercise_name'];
        } */




    }
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
                    if (isset($strength_workout) && $strength_workout['strength_workout_name'] == $strength['strength_workout_name']) {
                        echo 'selected';
                    }
                    ?> ) value="<?php
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
            <div class="table-responsive">
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
                    <?php foreach ($strength_Workout as $key):?>
                    <tr><input type="hidden" name="exercise_id[]" value="<?php echo $key['exercise_id'];?>"/>
                        <input type="hidden" name="strength_id[]" value="<?php echo $key['strength_id'];?>"/>
                        <td><?php echo $key['exercise_name'];?></td>
                        <td><select name="weight[]">
                                <?php
                                foreach (range(0, 200, 5) as $i):
                                    ?>
                                    <option
                                value="<?php
                                    echo $i;
                                    ?>"><?php
                                        echo $i;
                                        ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </td>
                        <td><select name="set_1[]">
                                <?php foreach (range(0, 15, 1) as $i):?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
                            </select>
                        </td>
                        <td><select name="set_2[]">
                                <?php foreach (range(0, 15, 1) as $i):?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
                            </select>
                        </td>
                        <td><select name="set_3[]">
                                <?php foreach (range(0, 15, 1) as $i):?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
                            </select>

                        </td>
                    </tr>

                    <?php endforeach;?>


                    </tbody>
                </table>
            </div>
        </form>
    </div>
    </div>
</main>
<?php
require_once '../Common Views/Footer.php';

?>
