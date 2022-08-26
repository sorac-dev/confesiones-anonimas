<?php
require('../core/server.php');
?>

<?php
if (isset($_SESSION['logeado'])  != "SI") {
   exit();
}
#Validacion de rangos
$consulta = $conn->query('SELECT codigo FROM invitacion WHERE id = "' .$id. '"');

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

if (isset($_POST['rango']) && isset($_POST['user'])) {

    $username =  strip_tags($_POST['user']);
    $rango_opcion = $_POST['rango'];
    
    $consulta = $conn->query("SELECT * FROM equipo WHERE username = '".$username."'");
    // Obtener la información del usuario
    $userData = $consulta->fetch();
    $user = $_POST['user'];

    if ($userData['username'] == "Sorac") {
        header("Location: ../ascender?ErrorForm");
?>
<?php
 } else {

    $actualizar = "UPDATE equipo SET rank = '$rango_opcion' WHERE username = '" . $username . "' ";

    $conn->query($actualizar);

    if ($rango_opcion == 1) {
        $rango = "Invitado";
    }
    if ($rango_opcion == 2) {
      $rango = "Moderador";
    }
    if ($rango_opcion == 3) {
      $rango = "Supervisor";
    }
    if ($rango_opcion == 4) {
      $rango = "Administrador";
    }
    
    $fecha_log = date("Y-m-d h:i:s", time());
    $username2 = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "cambio el rango de $username a $rango";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username2."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);
    // Log guardado en Base de datos
    
    header("Location: ../ascender?Ready");
}}
?>
<?=header("Location: ../ascender");?>

