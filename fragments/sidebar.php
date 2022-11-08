<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href=<?php echo $base."starter.php"?> class="brand-link">
        <img src=<?php echo $base."dist/img/AdminLTELogo.png" ?> alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <br>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <em class="fas fa-search fa-fw"></em>
                </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
                <em class="nav-icon fas fa-tachometer-alt"></em>
                <p>
                Main Menu
                <em class="right fas fa-angle-left"></em>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                <a href="./pages/files.php" class="nav-link" id="filesTagMenu">
                    <em class="far fa-file nav-icon"></em>
                    <p>Files</p>
                </a>
                </li>
                <li class="nav-item">
                    <a href="./pages/dailyLog.php" class="nav-link" id="dsTagMenu">
                        <em class="far fa-file nav-icon"></em>
                        <p>Daily Summary</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./pages/states.php" class="nav-link">
                        <em class="far fa-check-square nav-icon" id="stTagMenu"></em>
                        <p>States</p>
                    </a>
                </li>
            </ul>
            </li>
            <li class="nav-item">
            <a href="#" class="nav-link">
                <em class="nav-icon fas fa-th"></em>
                <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
                </p>
            </a>
            </li><li class="nav-item">
            <a href="#" class="nav-link">
                <em class="nav-icon fas fa-th"></em>
                <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
                </p>
            </a>
            </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>