<?php
require('../core/server.php');
$username = $_SESSION['username'];
    
#Datos
$fecha_log = date("Y-m-d h:i:s", time());
$ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
$pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
$accion = "ha cerrado la sesión";

$estado = '0';
#Actualizamos su estado
$update_invi = $conn->query("UPDATE equipo SET logeado='$estado' WHERE username = '$username'");

#Enviar a log login
$enviar_log = "INSERT INTO logs_login (user_login,accion,pais_login,ip_login,fecha) values ('{$username}','{$accion}','{$pais}','{$ip}','{$fecha_log}')";
$conn->query($enviar_log);

session_start(); 
session_unset();
session_destroy(); 
setcookie("id_extreme","x",time()-3600,"/");
header("Location: ../login");
?>