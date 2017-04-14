<?php
/*Created By Rahul Malik*/
require_once '../Common Views/Header.php';
require_once '../Common Views/sidebar.php';
$user_id = 1;
$ModuleID=1;
?>
<script src="/health-hack/Tracking/Scripts/script.js"></script>
<div id="main-content" class="col-md-9 col-sm-12 col-12 row">
  <div>
    <form name="FrmTrack"  id="FrmTrack">
	 <input type="hidden" name="FromLatitude" id="FromLatitude" value="">
	 <input type="hidden" name="FromLongitude" id="FromLongitude" value="">
	 <input type="hidden" name="ToLatitude" id="ToLatitude" value="">
	 <input type="hidden" name="ToLongitude" id="ToLongitude" value="">
		<div id="StartDiv">
			<input type="button" name="StartButton" id="StartButton" value="Start Tracking">
		</div>
		<div id="EndDiv">
			<input type="button" name="EndButton" id="EndButton" value="End Tracking">
		</div>
		<div id="CalculateDiv">
			<input type="button" name="CalculateButton" id="CalculateButton" value="Calculate Distance" >
		</div>
		
	</form>
  </div>
  
</div>
<?php
require_once '../Common Views/Footer.php';
?>


