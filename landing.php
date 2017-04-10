
<?php
// start session storage
session_start();
require_once './Models/Signup.php';


    //check if form is set
    if (isset($_POST['Register'])){
        // gets value of requested variable
        $fname = filter_input(INPUT_POST, "fName");
        $lName = filter_input(INPUT_POST, "lName");
        $email = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        //new instance of Signup()
        $db = new Signup();
        //call newUser() method in Signup()
        $db->newUser($fname, $lName, $email, $password);
    }

    //check if form is set (login)
    if (isset($_POST['Login'])){
        //echo "<script> console.log('attempted login'); </script>";

        // grab values from login form
        $loggedInUser = filter_input(INPUT_POST, 'loginUser');
        $loggedInPass = filter_input(INPUT_POST, 'loginPass');

        //new instance of Signup()
        $db = new Signup();
        //call newUser() method in Signup()
        $userId = $db->isValidUser($loggedInUser, $loggedInPass);

        // initialize new SESSION variable
        $_SESSION['user'] = $userId->user_id;
        var_dump($_SESSION['user']);
        //point page to create-routine.php
        header("Location: index.php");
    }
?>
<!--

    Authors: Kelly Ann McNamara
    Client: Health Hack
    Project: Php Group Project 2017
    Verison: 1.0

    _________________________________

    INDEX
    01. Top Bar
    02. Main Content

-->
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!--<meta http-equiv="refresh" content="5">-->
    <title>Health Hack</title>
    <link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="opt-imgs/favicon.png">
    <!-- Importing Files -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="./main.css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i" rel="stylesheet">
</head>
<body>
    <div id="landing-topbar" class="col-12">
        <img src="opt-imgs/logo.svg" alt="Health Hack Logo" width="43" />
    </div>
    <main id="landing-main" class="col-12 row">
        <h2 class="col-12">You will never know your limits unless you push yourself.</h2>
        <div id="landing-btns" class="col-12">
            <button type="button" id="loging-btn" data-toggle="modal" data-target="#loginModal">Login</button>
            <button type="button" id="signup-btn" data-toggle="modal" data-target="#SignupModal">Sign Up</button>
        </div>
    </main>
    <div id="loginModal" class="modal fade" role="form">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
                <img src="opt-imgs/login-photo.png" class="profile-photo" alt="Profile Photo" />
                <h2>Health Hack</h2>
            <form action="landing.php" method="post" id="login-form">
                <div class="form-field">
                    <label for="loginUser" class="formLabel">Email</label>
                    <input type="text" id="loginUser" name="loginUser" class="textInput" placeholder="Email" />
                </div>
                <div class="form-field">
                    <label for="loginPass" class="formLabel">Password</label>
                    <input type="password" id="loginPass" name="loginPass" class="textInput" placeholder="Password" />
                </div>
                <input type="submit" class="formSubmit" name="Login" value="Login" />
                <div class="form-field">
                    <button type="button" class="formResetBtn">Reset Your Password</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div>

        <div id="SignupModal" class="modal fade" role="form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <img src="opt-imgs/login-photo.png" class="profile-photo" alt="Profile Photo" />
                        <h2>Health Hack</h2>
                        <h3>Create an Account</h3>
                        <form action="landing.php" method="post">
                            <div class="form-field">
                                <label class="formLabel">First Name</label>
                                <input type="text" class="textInput" name="fName" placeholder="First Name"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Last Name</label>
                                <input type="text" class="textInput" name="lName" placeholder="Last Name"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Email</label>
                                <input type="email" class="textInput" name="email" placeholder="Email"/>
                            </div>
                            <div class="form-field">
                                <label class="formLabel">Password</label>
                                <input type="password" class="textInput" name="password" placeholder="Password" />
                                <span class="text-info">Passwords must be 8 characters, contain at least 1 number and one capital letter. </span>
                            </div>
                            <input type="submit" class="button" name="Register" value="Register" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
    <!-- Importing Files -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <script src="Scripts/script.js"></script>
</html>
