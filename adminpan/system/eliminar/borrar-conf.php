<?php 
require('../../core/server.php');
#Validacion de rangos
$consulta = $conn->query('SELECT * FROM conf_respuestas WHERE id = "' .$id. '"');

$mi_id = $_SESSION['id'];
$consult = $conn->query('SELECT rank FROM equipo WHERE id = "'.$mi_id.'"');
while ($datos = $consult->fetch()) {
    $rangouser = $datos['rank'];
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

if (isset ($_GET['id'])){
	
    $id = $_GET['id'];
    
    $msg_remove = "«Este mensaje ha sido reportado por la comunidad»";
    $consulta = "UPDATE conf_respuestas SET confesion = '$msg_remove' WHERE id = $id";
    $conn->query($consulta);
        
    // Guardar acción en Logs si se ha iniciado sesión
    
    $fecha_log = date("Y-m-d h:i:s", time());
    $username = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "Elimino una confesion";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);
    // Log guardado en Base de datos
    
    header("Location: ../../confesiones");
}


?>