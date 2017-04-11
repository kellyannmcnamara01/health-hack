<?php
    require_once('../Common Views/Header.php');
    require_once('../Common Views/sidebar.php');
?>

<div id="fitness-progress" class='col-md-9 col-sm-12 col-12'>
    <h2>Find out your Fitness Progress</h2>
    <?php if ($action == "Index") { ?>
        <div id="progress-place" class="row">
            <div id="strength" class="col-sm-12">
                <form method="post">
                    <input type="submit" name="sbmStrength" class="btn btn-default" value="Strength" />
                </form>
            </div>
            <div id="cardio" class="col-sm-12">
                <form method="post">
                    <input type="submit" name="sbmCardio" class="btn btn-default" value="Cardio" />
                </form>
            </div>
        </div>
    <?php } ?>

    <?php if ($action == "Strength") { ?>
    <h3><?php echo $_SESSION["workout-type"]; ?></h3>
        <div id="strengthControls">
            <div class="form-group">
                <select name="month" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <select name="year" class="form-control">
                </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info" value="Show Progress" />
            </div>
        </div>
    <?php } ?>
</div>

<?php require_once('../Common Views/Footer.php'); ?>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<?php if ($action == "Strength") { ?>
<script src="../Scripts/strength.js?v=1"></script>
<?php } ?>
