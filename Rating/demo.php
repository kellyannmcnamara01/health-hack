<?php
/*Created By Rahul Malik*/
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;
$ModuleID=1;
?>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
  <div>
  <script src="/health-hack/Rating/Scripts/script.js"></script>
    <?php require_once("../Rating/rating.php");?>
  </div>
</div>
<?php
require_once '../Common Views/Footer.php';
?>
