<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
    echo $calendar->draw($db);
    require_once('../Common Views/Footer.php');
?>