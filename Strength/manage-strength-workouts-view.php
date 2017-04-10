<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-08
 * Time: 4:28 PM
 */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';

?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <form action="#" method="post">
                <h1 class="red">Manage Cardio Workouts</h1>
                <p class="badge badge-success"><?php if (isset($success_message)){ echo $success_message;} ?></p>
                <p>Here, you can delete strength workouts. All instances of the strength workout will also be deleted in your completed strength workouts.</p>
                <p>If the workout is part of a routine, that routine will also be deleted.</p>

                <h2>Your Strength Workouts</h2>
                <?php foreach ($strength_workouts as $i):?>
                    <div class="checkbox">
                        <label><input type="checkbox" name="strength_check[]" value="<?php echo $i['strength_id']?>"><?php echo $i['strength_workout_name']?></label>
                    </div>
                <?php endforeach;?>

                <div class="spacing">
                    <input  type="submit" name="delete_strength" value="Delete Strength Workouts" class="formSubmit offset-md-1 col-md-3 col-sm-6 col-xs-1 offset-sm-3    "/>
                </div>
            </form>
            <span class="badge badge-danger"><?php if (isset($delete_error)){ echo $delete_error;}?></span>

        </div>
    </div>
    </div>
    </main>


<?php
require_once '../Common Views/Footer.php';
?>