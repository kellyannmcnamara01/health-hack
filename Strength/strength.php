<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-26
 * Time: 4:28 PM
 */

require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>

    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">

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
                <a href="quick-strength-workout.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/strength-icon.png" alt="" />
                    </div>
                    <p class="text-center">Quick Strength Workout</p>
                </a>
            </div>
        </div>
    </div>
    </main>

<?php
require_once '../Common Views/Footer.php';
?>