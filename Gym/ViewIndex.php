<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>
<div class='col-sm-9'>
    <div id='gymlist'>
        <h2>My Gyms</h2>
        <?php if (isset($addedGym)) : ?>
            <?php if ($addedGym != true) { ?>
                <span class='alert alert-danger'><?php echo $addedGym; ?></span>
            <?php } else { ?>
                <span class='alert alert-success'>New Location was successfully added to your list!</span>
            <?php } ?>
        <?php endif; ?>
        <?php echo $gymObj->displayGymList(); ?>
    </div>
</div>
<?php
    require_once('../Common Views/Footer.php');
?>