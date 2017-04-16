<?php
ob_start();
//start session
session_start();

require_once './Models/Signup.php';
require_once './Models/Profile.php';


// check if $_GET paramaters exist on incoming URI
if (isset($_GET['access_token'])) {
    $test = $_GET['access_token'];
    // var to hold URI from GET request (from email)
    $emailRefer = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    // set var to hold the value of the access_token from specific request
    $access_token = substr($emailRefer, strpos($emailRefer, "access_token=") +13);
    //echo $access_token;

    // new instance of Profile()
    $db = new Profile();

    // call GetUserIdByToken()
    $profile = $db->GetUserIdByToken($access_token);

    // initialize new SESSION variable
    $_SESSION['user'] = $profile->user_id;
    // set $user to $_SESSION['user']
    $user = $_SESSION['user'];
}else{
    $test = '';
}

require_once 'redirect.php';

// est. variable that contains session variable for email
$user = $_SESSION['user'];



//new instance of Signup()
$db = new Signup();


// call userInfo() method
$userId = $db->userInfo($user);
//grab username, email

// *** $id & $userFirst variables are needed for sidebar.php and need to be on every page
$userFirst = $userId->first_name;
$id = $userId->user_id;

$userFirst = $userId->first_name;
$userName = $userId->first_name . ' ' . $userId->last_name;
$userEmail = $userId->email;


require_once 'Common Views/Header.php';
require_once 'Common Views/sidebar.php';

?>
        <!-- Logout Modal -->

        <!-- 02-2-2. Main Content -->
        <div id="main-content" class="col-md-9 col-sm-12 col-12 row">
            <!-- 02-2-2-1. Intro Banner -->
            <div id="intro-banner" class="col-md-12 col-sm-12 col-12">
                <h1>Welcome Back <?php echo $userName; ?>
                </h1>
            </div>
            <!-- 02-2-2-2. Feature Call Out -->
            <div id="feature-callouts" class="col-md-9 col-sm-9 col-12 row">
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Routines/routines.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="./opt-imgs/routine-icon.png" alt="" />
                        </div>
                        <p class="text-center">Routines</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="GroceryList/FoodDiaryEntry.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/foodlog-icon.png" alt="" />
                        </div>
                        <p class="text-center">Food Diary</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="FitnessProgress/index.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/fitnessprogress-icon.png" alt="" />
                        </div>
                        <p class="text-center">Fitness Progress</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="CardioFeature/Cardio.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/cardio-icon.png" alt="" />
                        </div>
                        <p class="text-center">Cardio Workouts</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="GroceryList/Grocery.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/foodgoals-icon.png" alt="" />
                        </div>
                        <p class="text-center">Nutrition Statistics</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Strength/strength.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/strength-icon.png" alt="" />
                        </div>
                        <p class="text-center">Strength Workouts</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Tracking/TrackMe.php" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/distance-icon.png" alt="" />
                        </div>
                        <p class="text-center">Track Distance</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="Gym" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/gymlocation-icon.png" alt="" />
                        </div>
                        <p class="text-center">Gyms</p>
                    </a>
                </div>
                <div class="feature col-md-4 col-sm-4 col-4">
                    <a href="#" class="feature-btn">
                        <div class="feature-icon">
                            <img src="opt-imgs/friends-icon.png" alt="" />
                        </div>
                        <p class="text-center">Friends</p>
                    </a>
                </div>
            </div>
            <!-- 02-2-2-3. Progress -->
            <div id="progress-recap" class="col-md-3 col-sm-3 col-12">
                <h2 class="light-grey">Progress</h2>
            </div>
        </div>
    </main>
    <!-- 02-2-3. Footer -->
   <?php
    require_once 'Common Views/Footer.php';
    ?>