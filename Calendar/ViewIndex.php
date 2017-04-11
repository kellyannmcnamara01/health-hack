<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>
    <div id='calendar-feature' class='col-md-9 col-sm-12'>
        <h3>Today is <?php echo date('l'); ?></h3>
        <p>Check out what is on Agenda</p>
        <?php echo $calendar->drawMobile(); ?>
    </div>
<?php
    require_once('../Common Views/Footer.php');
?>