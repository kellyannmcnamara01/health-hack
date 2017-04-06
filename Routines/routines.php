<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:44 PM
 */
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">

        <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-4 col-sm-4 col-4">
                <a href="create-routine.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/Create-Cardio-Icon.jpg" alt="" />
                    </div>
                    <p class="text-center">Create a Routine</p>
                </a>
            </div>
            <div class="feature col-md-4 col-sm-4 col-4">
                <a href="manage-routines.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/Log-Cardio-Icon.jpg" alt="" />
                    </div>
                    <p class="text-center">Manage Routines</p>
                </a>
            </div>
        </div>
</div>
</main>
            <?php
            require_once '../Common Views/Footer.php';
            ?>
