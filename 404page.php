<?php
header($_SERVER["SERVER_PROTOCOL"], true, 404);
include('logout.php'); // provide your own HTML for the error page
die();
?>