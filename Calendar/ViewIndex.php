<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
    echo $calendar->draw();
    require_once('../Common Views/Footer.php');
?>