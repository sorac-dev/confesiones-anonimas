<header>
<div class="navbar-p">
    <ul>
        <?php
        require_once('../core/server.php');
        $consulta = $conn->query('SELECT rank FROM equipo WHERE username = "' . $_SESSION['username'] . '"');
        while ($row = $consulta->fetch()) {
            $rangouser = $row['rank'];
        }
        if ("$rangouser" >= "1") {
            echo '
            <li><a href="../admin/index">Inicio</a></li>
            ';
         }
        if ("$rangouser" >= "2") {
           echo '
           <li><a href="../admin/reports">Reportes</a></li>
           <li><a href="../admin/confesiones">Confesiones</a></li>
           <li style="display:none;"><a href="../admin/stats">Estadisticas</a></li>
           ';
        }
        if ("$rangouser" >= "3") {
            echo '
           <li><a href="../admin/logs">Logs</a></li>
           <li><a href="../admin/change-pass">Cambiar contraseña</a></li>
           <li><a href="../admin/invitaciones">Invitaciones</a></li>
           ';
        }
        echo '<li style="float: right; margin: 0;"><a href="/admin/system/logout.php">Logout</a></li>';
        ?>
    </ul>
</div> 
<br><br>
</header>
<body id="body-panel">