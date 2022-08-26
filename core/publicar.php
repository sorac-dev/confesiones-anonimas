<?php 
require('../core/server.php');
?>
<?php
if ((isset($_POST['edad'])) && (isset($_POST['genero']))  && (isset($_POST['confesion']))) {
    $age   = ( empty($_POST['edad']) )   ? NULL : $_POST['edad']; //Validar que no este vacio
    $conf   = ( empty($_POST['confesion']) )   ? NULL : $_POST['confesion']; //Validar que no  este vacio

    //Generar id aleatoria
    $rand_n1 = rand(1,9999);
    $rand_n2 = rand(99,9999);
    $rand_result = $rand_n1 + $rand_n2 * 2;

    #Volver caracteres especiales
    $conf2 = strip_tags($conf);
    $confe = htmlspecialchars($conf2);

    //Fecha log
    $fecha_log = date('d-M-Y', time());
    $time_log = date('h:i', time());

    //Direccion ip y el pais
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

    $genero = $_POST['genero'];

    #Verificamos que este activo confesiones
    $cons = $conn->query("SELECT * FROM config WHERE id='1'");
    $dataConf = $cons->fetch();

#Validamos confesion
if (!$age || !$conf || $age >= '100' || $age <= '2' || $genero >= '5' || $genero <= '1' || empty(($conf))) {
    header("Location: ../index?Error");
?>
<?php 
exit();
} if ($dataConf['confesiones'] == "0") {
    header("Location: ../index?confesiones-desabilitadas");
?>
<?php    
exit(); } else {
    #Enviar confesion
    $send = "INSERT INTO conf_respuestas (id_conf, edad, genero, confesion, date_conf, time_conf, pais, ip_user) values ('" . strip_tags($rand_result) . "','" . strip_tags($age) . "','" . strip_tags($_POST['genero']) . "','" . $confe . "','" . strip_tags($fecha_log) . "', '" . strip_tags($time_log) . "','" . strip_tags($pais) . "','" . strip_tags($ip) . "')";
    $conn->query($send);

    #Datos
    $accion    = "$ip hizo una confesión.";
    $fecha_c = date("Y-m-d h:i:s", time());
    
    #Enviar a log moderacion
    $enviar_log = "INSERT INTO logs_conf (id_conf,accion,ip_user,fecha) values ('{$rand_result}','{$accion}','{$ip}','{$fecha_c}')";
    $conn->query($enviar_log);
    header("Location: ../");
?>
<?php }} ?>