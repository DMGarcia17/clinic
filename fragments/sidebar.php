<?php
    echo "<input type='hidden' id='hostname' value='".host."'>";
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href=<?php echo $base."starter.php"?> class="brand-link">
        <img src=<?php echo $base."dist/img/logoh_trs.png" ?> alt="AdminLTE Logo"  style="opacity: 0.8; height: 9vh;">
        <span class="brand-text font-weight-light">&nbsp;</span>
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
            <li class="nav-item">
            <a <?php echo 'href="http://'.host.'/clinic/pages/calendar.php"' ?> class="nav-link" id="calendarTag">
                <em class="nav-icon fa fa-calendar"></em>
                <p>Agenda</p>
            </a>
            </li>
            <li class="nav-item">
                <a <?php echo 'href="http://'.host.'/clinic/pages/patients.php"' ?> class="nav-link" id="patientTag">
                    <em class="nav-icon fa fa-person"></em>
                    <p>Pacientes</p>
                </a>
            </li>
            <li class="nav-item">
                <a <?php echo 'href="http://'.host.'/clinic/pages/appointments.php"' ?> class="nav-link" id="appointmentTag">
                    <em class="nav-icon fa fa-user-nurse"></em>
                    <p>Citas M&eacute;dicas</p>
                </a>
            </li>
            <li class="nav-item menu-open">
                <a href="#" class="nav-link">
                    <em class="nav-icon fas fa-tachometer-alt"></em>
                    <p>
                    Cat&aacute;logos
                    <em class="right fas fa-angle-left"></em>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a <?php echo 'href="http://'.host.'/clinic/pages/clinics.php"' ?> class="nav-link" id="clinicsTagMenu">
                        <em class="fa fa-hospital nav-icon"></em>
                        <p>Cl&iacute;nicas</p>
                    </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="http://localhost/clinic/pages/diseases.php"' ?> class="nav-link" id="diseasesTagMenu">
                            <em class="fa fa-disease nav-icon"></em>
                            <p>Enfermedades</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="http://localhost/clinic/pages/allergies.php"' ?> class="nav-link" id="allergiesTagMenu">
                            <em class="fa fa-hand-dots nav-icon"></em>
                            <p>Alergias</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a <?php echo 'href="http://'.host.'/clinic/pages/treatments.php"' ?> class="nav-link" id="treatmentsTagMenu">
                            <em class="fa fa-syringe nav-icon"></em>
                            <p>Tratamientos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a <?php echo 'href="http://'.host.'/clinic/pages/medicalQuestions.php"' ?> class="nav-link" id="medicalQuestionsTagMenu">
                            <em class="fa fa-question nav-icon"></em>
                            <p>Preguntas Medicas</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="http://localhost/clinic/pages/medicines.php" class="nav-link" id="medicinesTagMenu">
                            <em class="fa fa-tablets nav-icon"></em>
                            <p>Medicamentos</p>
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a <?php echo 'href="http://'.host.'/clinic/pages/users.php"' ?> class="nav-link" id="usersTagMenu">
                            <em class="fa fa-user nav-icon"></em>
                            <p>Usuarios</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
            <a <?php echo 'href="http://'.host.'/clinic/controllers/SessionController.php?function=D"' ?> class="nav-link" id="patientTag">
                <em class="nav-icon fa fa-power-off"></em>
                <p>Cerrar Sesi&oacute;n</p>
            </a>
            </li>
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>