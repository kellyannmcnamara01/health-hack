<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-04-06
 * Time: 2:44 PM
 */
session_start();
require_once '../redirect.php';
require_once '../Models/Signup.php';
require_once '../Models/Profile.php';
$user = $_SESSION['user'];

// call userInfo() method using user_id from $_SESSION
$db = new Signup();

$userId = $db->userInfo($user);

//grab  user id, username
$id = $userId->user_id;
$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
    <div class="container">
        <div class="row spacing">
            <span class="badge badge-success"><?php if (isset($_COOKIE['success'])){ echo $_COOKIE['success'];}?></span>
        </div>
    </div>
        <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
        <div class="feature col-md-4 col-sm-4 col-4">
                <a href="create-routine.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/routine-icon.png" alt="" />
                    </div>
                    <p class="text-center">Create a Routine</p>
                </a>
            </div>
            <div class="feature col-md-4 col-sm-4 col-4">
                <a href="manage-routines.php" class="feature-btn">
                    <div class="feature-icon">
                        <img src="../opt-imgs/manage.png" alt="" />
                    </div>
                    <p class="text-center">Manage Routines</p>
                </a>
            </div>

        </div>
    <div class="row col-md-6 offset-md-1 offset-sm-1 offset-xs-1">
        <a href="../index.php" class="btn btn-info btn-lg offset-md-0">
            <span class="glyphicon glyphicon-circle-arrow-left"></span>Back
        </a>
    </div>

</div>
</main>
            <?php
            require_once '../Common Views/Footer.php';
            ?>
