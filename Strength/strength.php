<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 4:28 PM
 */

session_start();
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>

    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
<div class="row spacing">
    <span class="badge badge-success"><?php if (isset($_SESSION['strength_success'])){ echo $_SESSION['strength_success'];}?></span>
</div>
        </div>
        <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">

            <div class="feature col-md-4 col-sm-4 col-4">

                <a href="create-strength.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/strength-icon.png" alt="" />
                    </div>
                    <p class="text-center">Create Strength Workout</p>
                </a>
            </div>
            <div class="feature col-md-4 col-sm-4 col-4">
                <a href="log-strength.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/strength-icon.png" alt="" />
                    </div>
                    <p class="text-center">Log a Strength Workout</p>
                </a>
            </div>
            <div class="feature col-md-4 col-sm-4 col-4">
                <a href="manage-strength-workouts.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/strength-icon.png" alt="" />
                    </div>
                    <p class="text-center">Manage Strength Workouts</p>
                </a>
            </div>

        </div>
    </div>
    </main>

<?php
require_once '../Common Views/Footer.php';
?>