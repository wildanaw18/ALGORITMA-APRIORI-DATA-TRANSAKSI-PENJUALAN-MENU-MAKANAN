<?php
$menu_active = '';
if (isset($_GET['menu'])) {
    $menu_active = $_GET['menu'];
}
?>

<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.php" class="logo logo-dark">
            <span class="logo-sm">
                <img src="assets/themesbrand.com/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/themesbrand.com/assets/images/logo-dark.png" alt="">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.php" class="logo logo-light">
            <span class="logo-sm">
                <img src="assets/themesbrand.com/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/themesbrand.com/assets/images/logo-light.png" alt="">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Apps</span></li>
                <li <?php echo ($menu_active == '') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php" aria-expanded="false"
                        aria-controls="sidebarDashboards">
                        <i class="ri-home-5-line"></i> <span data-key="t-dashboards">Dashboards</span>
                    </a>

                </li> <!-- end Dashboard Menu -->
                <li <?php echo ($menu_active == 'data_transaksi') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php?menu=data_transaksi" aria-expanded="false"
                        aria-controls="sidebarApps">
                        <i class="ri-table-line"></i> <span data-key="t-apps">Data</span>
                    </a>

                </li>
                <li class="menu-title"><span data-key="t-menu">Apriori</span></li>
                <?php if($_SESSION['apriori_parfum_level'] == 1){ ?>
                <li <?php echo ($menu_active == 'proses_apriori') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php?menu=proses_apriori" aria-expanded="false"
                        aria-controls="sidebarLayouts">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Proses</span>
                    </a>

                </li>
                <?php
                    }
                ?>
                <li <?php echo ($menu_active == 'hasil_apriori') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php?menu=hasil_apriori" aria-expanded="false"
                        aria-controls="sidebarAuth">
                        <i class="ri-bookmark-line"></i> <span data-key="t-authentication">Hasil</span>
                    </a>

                </li>
                <!-- <li class="menu-title"><span data-key="t-menu">Hash-Based</span></li>
                <?php if($_SESSION['apriori_parfum_level'] == 1){ ?>
                <li <?php echo ($menu_active == 'proses_hashbased') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php?menu=proses_hashbased" aria-expanded="false"
                        aria-controls="sidebarLayouts">
                        <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Proses</span>
                    </a>
                </li>
                <?php
                    }
                ?>
                <li <?php echo ($menu_active == 'hasil_hashbased') ? "class='active'" : ""; ?>>
                    <a class="nav-link menu-link" href="index.php?menu=hasil_hashbased" aria-expanded="false"
                        aria-controls="sidebarAuth">
                        <i class="ri-bookmark-line"></i> <span data-key="t-authentication">Hasil</span>
                    </a>
                </li> -->
                <li class="menu-title"><span data-key="t-menu">Extra</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="logout.php" aria-expanded="false" aria-controls="sidebarPages">
                        <i class="ri-logout-circle-fill"></i> <span data-key="t-pages">Logout</span>
                    </a>

                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>