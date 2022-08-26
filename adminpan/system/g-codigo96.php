<?php
if (isset($_POST['generar'])) {
    require('../core/server.php');
    #Validacion de rangos
    $mi_id = $_SESSION['id'];
    $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "'.$mi_id.'"');
    while ($datos = $consulta->fetch()) {
        $username = $datos['username'];
    }
    if ($rangouser == "1") {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    if ($rangouser == "2") {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
    if ($rangouser == "3") {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    exit();
} else {

        $user = $_SESSION['username'];

        #Direccion IP y Pais
        $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
        $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    
        //Generar code aleatoria
        $rand = rand(15,99919);
        $rand_result = $rand * 6;
        $c1 = sha1($rand_result);
        $code = md5($c1);
    
        #Fecha
        $fecha_all = date("Y-m-d h:i:s", time());
    
        #Enviar codigo generado a la base de datos
        $consulta3 = $conn->query("INSERT INTO invitacion (codigo,fecha_creacion) VALUES ('{$code}','{$fecha_all}')");
    
        #Guardado logs
        $accion = "Genero un codigo de invitación";
        $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$user."','".$accion."','".$fecha_all."')";
        $conn->query($enviar_log);
}
?>
<script type="text/javascript">
  location.href ="../invitacion.php";
</script>