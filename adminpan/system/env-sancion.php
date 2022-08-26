<?php
require('../core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI")
{
    exit();
} else {
    #Validacion de rangos
    $mi_id = $_SESSION['id'];
    $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "' . $mi_id . '"');
    while ($datos = $consulta->fetch())
    {
        $rangouser = $datos['rank'];
    }
    if ($rangouser == "1")
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    if (isset($_POST['ip']) && isset($_POST['razon']) && isset($_POST['fin'])) {

        #Datos
        $inicio = date ('Y-m-d', time());
        $fin = nl2br($_POST['fin']);
        $razon = strip_tags($_POST['razon']);
        $ip_p = $_POST['ip'];

        #Consultamos a la tabla baneos
        $consulta = $conn->query('SELECT * FROM baneos WHERE ip_ban = "' . $ip_p . '"');
        $data = $consulta->fetch();

    if ($ip_p == $data['ip_ban'] || $razon == NULL) {
        header("Location: ../sancionar?Error")
?>
<?php
exit(); } else {
    #Enviamos datos
    $conn->query("INSERT INTO baneos (ip_ban,razon,fecha_inicio,fecha_fin) values ('{$ip_p}','{$razon}','{$inicio}','{$fin}')");

    #Guardar Logs
    $log_time = date("Y-m-d h:i:s", time());
    $accion = "baneo una direccion ip";
    $mod = $_SESSION['username'];

    $send_log = "INSERT INTO logs_sanciones (usuario, accion, ip_baneada, razon, fecha_inicio, fecha_fin, fecha_log) 
    values ('{$mod}','{$accion}','{$ip_p}','{$razon}','{$inicio}','{$_POST['fin']}','{$log_time}')";
    $sed = $conn->query($send_log);

  
    $fecha_log = date("Y-m-d h:i:s", time());
    $username = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "baneno una direccion ip $ip_p";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);
    // Log guardado en Base de datos

    header("Location: ../sancionar?ip-sancionada")
?>
<?php }}}?>
