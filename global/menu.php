<link rel="stylesheet" href="../Library/fontawesome-free/css/all.min.css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="../Library/bootstrap/css/bootstrap-select.min.css">
<link rel="stylesheet" href="../Library/sweetalert2/sweetalert2.min.css">
<link rel="stylesheet" href="../Library/datatables/css/datatables.min.css">
<link href="../css/sb-admin-2.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <span class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-faucet"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Agua Atmoloni<sup>1.2</sup></div>
            </span>

            <li class="nav-item">
                <a class="nav-link" id="itemHome" href="./home.php">
                    <i class="fas fa-house-user"></i>
                    <span>Home</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="itemHome" href="./titulares.php">
                    <i class="fas fa-hand-holding-water"></i>
                    <span>Titulares</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="itemHome" href="./reuniones.php">
                    <i class="fas fa-tools"></i>
                    <span>Faenas</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="itemHome" href="./transacciones.php">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transacciones</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline" id="btnExpandir">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" type="button" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">admin</span>
                                <img class="img-profile rounded-circle" src="../img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../Archivos/sesion/Operaciones_Sesion.php?op=Cerrar_Sesion" id="itemLogout">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">