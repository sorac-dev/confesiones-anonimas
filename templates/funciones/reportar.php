<?php
require('../../core/server.php');
?>
<?php
if (isset($_POST['id_post'])) {

    #Validar datos para evitar SQL inject
    $id_conf = strip_tags($_POST['id_post']);

    #Consultar las confesiones
    $conf = $conn->query("SELECT * FROM conf_respuestas WHERE id_conf='$id_conf'");
    $row = $conf->fetch();

    #Datos que necesitaremos
    $id_actual = $id_conf;
    $ip_denunciado = $row['ip_user'];

    $ip_actual = $_SERVER["HTTP_CF_CONNECTING_IP"];
    #$ip_actual = $_SERVER['REMOTE_ADDR'];
    $fecha_all = date("Y-m-d", time());

    #Hacemos consulta
    $consult = $conn->query("SELECT * FROM reportes WHERE id_conf='$id_conf'");
    $data = $consult->fetch();

    #Validamos que el usuario si ya reporto la confesion no deje hacerlo
    if ($data['ip_denunciante'] == $ip_actual) {
        header("Location: ../../index");
?>
<?php
exit();
    #Validamos que exista el id de la confesión
    } if (!$id_actual == $row['id_conf']) {
        header("Location: ../../index");
?>
<?php
exit();
    #Validamos que no este vacio la casilla id_conf
    } if ($id_actual == NULL) {
        header("Location: ../../index");
?>
<?php
exit();
    } else {
        #Insertamos la denuncia
        $enviar = $conn->query("INSERT INTO reportes (id_conf, ip_denunciante, ip_denunciado,fecha) VALUES ('{$id_actual}','{$ip_actual}', '{$ip_denunciado}', '{$fecha_all}')");

        #Guardado logs
        $accion = "Se hizo una denuncia con la ip <b>$ip_actual</b> a la confesion id <b>$id_actual</b>";
        $enviar_log = "INSERT INTO logs_reportes (ip_denunciante,accion,fecha) values ('{$ip_actual}','{$accion}','{$fecha_all}')";
        $conn->query($enviar_log);
        header("Location: ../../index");
    ?>
<?php }}?>
<script>location.href="../../index";</script>