<?php
require('./core/server.php');
?>
<?php
    $mi_id = $_SESSION['id'];
    $consulta = $conn->query("SELECT * FROM equipo WHERE id ='$mi_id'");
    while ($row = $consulta->fetch()) {
        $name = $row['username'];
        $num_rank = $row['rank'];
        $mi_avatar = $row['avatar'];
    }

    #Cargar nombre rango
    $rangos = $conn->query("SELECT * FROM rangos WHERE id = '$num_rank'");
    while ($rango = $rangos->fetch()) {
        $mi_rank = $rango['rank'];
    }
?>
<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Spinner End -->
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-light navbar-light">
                <a href="index" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>ADMINCONF</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?=$mi_avatar?>" alt="" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0"><?php echo $name ?></h6>
                        <span><?php echo $mi_rank ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <?php
                    if ($num_rank >= "1") {
                        echo  '
                        <a href="dashboard" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        ';
                    }
                    if ($num_rank >= "2") {
                        echo  '
                        <a href="reportes" class="nav-item nav-link"><i class="fa fa-exclamation-circle me-2"></i>Reportes</a>
                        <a href="confesiones?buscar=0" class="nav-item nav-link"><i class="fa fa-search me-2"></i>Confesiones</a>
                        <a href="equipo" class="nav-item nav-link"><i class="bi bi-people"></i> Equipo moderación</a>
                        <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-gear"></i> Logs</a>
                        <div class="dropdown-menu bg-transparent border-0">
                        <a href="logs_confesiones" class="dropdown-item"><i class="bi bi-pencil-square"></i> Confesiones</a>
                        ';
                    }
                    if ($num_rank >= "3") {
                        echo  '
                        <a href="logs_reportes" class="dropdown-item"><i class="bi bi-lock"></i> Reportes</a>
                        <a href="logs_ingresos" class="dropdown-item"><i class="bi bi-plug"></i> Ingresos</a>
                        <a href="logs_sospechoso" class="dropdown-item"><i class="bi bi-plug"></i> Sospechosos</a>
                        ';
                    }
                    if ($num_rank >= "4") {
                        echo '
                        <a href="logs_sanciones"class="dropdown-item"><i class="bi bi-shield-x"></i> Sanciones</a>
                        <a href="logs_global"class="dropdown-item"><i class="bi bi-globe"></i> Global</a>
                        ';
                    }
                    if ($num_rank >= "3") {
                        echo '
                        </div></div>
                        <a href="sancionar" class="nav-item nav-link"><i class="bi bi-shield-exclamation"></i> Bloquear IP</a>
                        ';
                    }
                    if ($num_rank >= "4") {
                        echo  '
                        <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-gear"></i> Herramientas</a>
                        <div class="dropdown-menu bg-transparent border-0">
                        <a href="ascender" class="dropdown-item"><i class="bi bi-life-preserver"></i> Cambiar rango</a>
                        <a href="change-pass" class="dropdown-item"><i class="bi bi-lock"></i> Cambiar contraseñas</a>
                        <a href="invitacion" class="dropdown-item"><i class="bi bi-person-plus"></i> Crear invitacion</a>
                        <a href="b-usuario" class="dropdown-item"><i class="bi bi-person-x"></i> Eliminar usuario</a>
                        <a href="configuracion" class="dropdown-item"><i class="bi bi-wrench"></i> Configuración web</a>
                        </div></div>
                        ';
                    }
                    ?>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->
        
        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Search" style="display: none;">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <!-- Novedades -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fa fa-bell me-lg-2"></i>
                            <span class="d-none d-lg-inline-flex">Novedades</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0" style="box-shadow: 1px 1px 1px 1px #000;">
                            <a href="#" class="dropdown-item">
                                <h6 class="fw-normal mb-0">Se creo panel adminsitrativo.</h6>
                                <small>2/06/2022 4:23P.M</small>
                            </a>
                            <hr class="dropdown-divider">
                            <a href="#" class="dropdown-item text-center">Marcar como vistos</a>
                        </div>
                    </div>
                    <!-- Fin novedades -->

                    <!-- Perfil -->
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?=$mi_avatar?>" style="width: 40px !important;">
                            <span class="d-none d-lg-inline-flex"><?php echo $name ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
                            <a href="#" class="dropdown-item">Ajustes</a>
                            <a class="dropdown-item" onclick="window.location.href='system/logout.php'">Salir</a>
                        </div>
                    </div>
                    <!-- Fin perfil -->

                </div>
            </nav>
            <!-- Navbar End -->
