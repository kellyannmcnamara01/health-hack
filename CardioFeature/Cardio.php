<?php
session_start();
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
    <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
        <div class="container">
            <div class="row spacing">
                <span class="badge badge-success"><?php if (isset($_SESSION['cardio_success'])){ echo $_SESSION['cardio_success'];}?></span>
            </div>
        </div>
        <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-6 col-sm-6 col-6">
                <a href="create-cardio.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/Create-Cardio-Icon.jpg" alt="" />
                    </div>
                    <p class="text-center">Create Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="log-cardio.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/Log-Cardio-Icon.jpg" alt="" />
                    </div>
                    <p class="text-center">Log a Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="quick-cardio-workout.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/fitnessprogress-icon.png" alt="" />
                    </div>
                    <p class="text-center">Quick Cardio Workout</p>
                </a>
            </div>
            <div class="feature col-md-6 col-sm-6 col-6">
                <a href="manage-cardio-workouts.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/fitnessprogress-icon.png" alt="" />
                    </div>
                    <p class="text-center">Manage Cardio Workouts</p>
                </a>
            </div>
        </div>
    </div>
</main>

<?php
require_once '../Common Views/Footer.php';
?>
