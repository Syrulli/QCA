<?php
$page = substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], "/") + 1);
?>
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Dashboard</div>

                <a class="nav-link text-white" <?= $page == "index.php" ? 'active bg-primary' : ''; ?> href="index.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gauge"></i></div>
                    <small style="font-size: smaller;">Overview</small>
                </a>

                <a class="nav-link text-white" <?= $page == "schedules.php" ? 'active bg-primary' : ''; ?> href="schedules.php">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-calendar-check"></i></div>
                    <small style="font-size: smaller;">Schedules a class</small>
                </a>

                <a class="nav-link text-white" <?= $page == "inventory.php" ? 'active bg-primary' : ''; ?> href="inventory.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-warehouse"></i></div>
                    <small style="font-size: smaller;">Inventory</small>
                </a>

                <a class="nav-link text-white" <?= $page == "borrowed_history.php" ? 'active bg-primary' : ''; ?> href="borrowed_history.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
                    <small style="font-size: smaller;">Borrowed History</small>
                </a>

                <a class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#update_acc" href="#">
                    <div class="sb-nav-link-icon"> <i class="fa-solid fa-gears"></i></div>
                    <small style="font-size: smaller;">Settings</small>
                </a>

                <a class="nav-link text-white" href="../logout.php">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                    <small style="font-size: smaller;">Logout</small>
                </a>
            </div>
        </div>
    </nav>
</div>

