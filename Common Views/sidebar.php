<!-- 02-2. Main Content -->
<main id="main" class="row">
    <!-- 02-2-1. Nav -->
    <nav id="nav" class="col-md-3 col-sm-0 col-0">
        <!-- 02-2-1-1. Profile Photo -->
        <div class="profile">
            <?php
            if($homepage == $currentpage || $homepage2 == $currentpage) {
                ?><img src="opt-imgs/profile-photo.png" class="profile-photo" alt="Profile Photo" /><?php
            } else {
                ?><img src="../opt-imgs/profile-photo.png" class="profile-photo" alt="Profile Photo" /><?php
            }
            ?>
            <!--<img src="../opt-imgs/profile-photo.png" class="profile-photo" alt="Profile Photo" />-->
            <!-- 02-2-1-2. User Details -->
            <h2>Aira Summers</h2>
            <h3>A_Summers_01</h3>
        </div>
        <!-- 02-2-1-3. Links -->
        <div class="nav-links">
            <ul>
                <li class="link-hover"><a href="#" title="Dashboard Link">Dashboard</a></li>
                <li class="link-hover"><a href="#" title="Calendar Link">Calendar</a></li>
                <li class="link-hover"><a href="" title="Fitness Link">Fitness</a></li>
                <li class="link-hover"><a href="#" title="Gym Locator Link">Gym Locator</a></li>
                <li class="link-hover"><a href="#" title="Nutrition Link">Nutrition</a></li>
                <li class="link-hover"><a href="#" title="Log Out Link">Log Out</a></li>
            </ul>
        </div>
    </nav>