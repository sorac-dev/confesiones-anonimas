<?php 
require('../../core/server.php');
#Validacion de rangos
$consulta = $conn->query('SELECT * FROM equipo WHERE id = "' .$id. '"');

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
	
    #Tomamos dato de la id
    $id = $_GET['id'];

    #Consultamos a la base de datos mediante la ID
    $cstm = $conn->query("SELECT * FROM equipo WHERE id = '$id'");
    $data = $cstm->fetch();

    #Name del id insertado
    $name = $data['username'];

    #Que no puedan borrar la cuenta del dios supremo osea yo jeje
    if ($data['username'] == "Sorac") {
        header("Location: ../../b-usuario");
?>
<?php
exit(); } else {

    #Consulta de eliminacion de usuario
    $consulta = "DELETE FROM equipo WHERE id='$id' LIMIT 1";
    $conn->query($consulta);
    
    #Guardamos datos de log
    $fecha_log = date("Y-m-d h:i:s", time());
    $username = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "Elimino una cuenta con el nombre de $name";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);
    
    header("Location: ../../b-usuario");
?>
<?php }}?>