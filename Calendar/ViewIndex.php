<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>
    <div id='calendar-feature' class='col-md-9 col-sm-12'>
        <h3>Today is <?php echo date('l'); ?></h3>
        <p>Check out what is on Agenda</p>
        <p>Working hours for your gym</p>
        <div id='gym-hours' class='row'></div>
        <?php echo $calendar->drawMobile(); ?>
    </div>
<?php
    require_once('../Common Views/Footer.php');
?>
<script type="text/javascript">
    <?php if ($calendar->getDefaultGym() !== false) { ?>
    var arr = <?php echo json_encode($calendar->getDefaultGymTime()) ?>;
    var gymHours = [];
    if (arr.result.opening_hours)
    {
        arr.result.opening_hours.weekday_text.forEach(function(item) {
            gymHours.push(item);
        });

        gymHours.forEach(function(item, index) {
            var elemwrap;
            var elem = $('<span></span>').html(item);
            if (index % 2 === 0) {
                elemwrap = $('<div class="col-sm-12 col-md-3"></div>').append(elem);
                $('#gym-hours').append(elemwrap);
            } else {
                $('#gym-hours > div:last-child').append(elem);
            }
        });
    } else {
        var elem = $('<p></p>').html("Working hours aren't available online");
        $('#gym-hours').append(elem);
    }
    <?php } else { ?>
        var elem = $('<p></p>').html("No Gym is currently selected!");
        $('#gym-hours').append(elem);
    <?php } ?>
</script>