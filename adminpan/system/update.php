<?php
require('../core/server.php');
#Verificar rango
$mi_id = $_SESSION['id'];
$consult = $conn->query('SELECT rank FROM equipo WHERE id = "'.$mi_id.'"');
while ($datos = $consult->fetch()) {
    $rangouser = $datos['rank'];
}
if ($rangouser == "1") {
    header("Location: dashboard");
    exit;
}
if ($rangouser == "2") {
    header("Location: dashboard");
    exit;
}
if ($rangouser == "3") {
    header("Location: dashboard");
    exit;
}
?>
<?php
if (isset($_POST['nameweb']) && isset($_POST['descripcion']) && isset($_POST['i_logo']) && isset($_POST['i_og']) && isset($_POST['mantenimiento']) && isset($_POST['confesiones']) && isset($_POST['msg_mtni'])) {
    
    #Datos
    $id = "1";
    $nameweb = strip_tags($_POST['nameweb']);
    $dscr = strip_tags($_POST['descripcion']);
    $i_logo = strip_tags($_POST['i_logo']);
    $i_og = strip_tags($_POST['i_og']);
    $mantenimiento = strip_tags($_POST['mantenimiento']);
    $confesiones = strip_tags($_POST['confesiones']);
    $msg_mtni = htmlentities($_POST['msg_mtni']);

    #Enviamos consulta de updates
    $consulta = "UPDATE config SET nameweb='$nameweb', descripcion='$dscr', image_og='$i_og', logo='$i_logo', mantenimiento='$mantenimiento', confesiones='$confesiones', msg_mtni ='$msg_mtni' WHERE id='$id'";
    $conn->query($consulta);

    #Guardamos datos de log
    $fecha_log = date("Y-m-d h:i:s", time());
    $username = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "Actualizo la configuración del sitio web";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);

    header("Location: ../configuracion");
}
?>