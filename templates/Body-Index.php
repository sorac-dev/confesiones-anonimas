<?php
    require('core/server.php');
    session_start();

?>
<?php
#Vamos a ver si estan activas las confesiones.
    $query = $conn->query('SELECT * FROM config WHERE id = 1');
    $queryConfig = $query->fetch();
    if ($queryConfig['confesiones']  == 1) {
        echo '';
    } else {
        echo '
        <div class="t-m1 alert-box">
            <p class="alert alert-warning a-red"> <b class="red">!</b> Actualmente las confesiones estan <b>desabilitadas</b>. </p>
        </div>
        ';
    }
?>
<div class="container">
    <?php
    include('./templates/funciones/formulario-conf.php');
    ?>
</div>
<?php
$errorID = $_SESSION['errorID'];

if ($errorID == 1) {
    $tipoError = 'Algo ocurrió al intentar enviar tu confesion, por favor intenta nuevamente.';
    
}
if ($errorID == 2) {
    $tipoError = 'Confesiones desabilitadas en este momento, intenta mas tarde.';
}
if ($errorID == 3) {
    $tipoError = 'Vas muy rapido, espera 3 segundo(s) para enviar otra confesion.';
}

if ($_SESSION['TengoError'] != true) {
    echo '';
} else {
?>
<div class="t-m1 alert-box">
    <p class="alert alert-warning a-red"> <b class="red">!</b> <?=$tipoError?> </p>
</div>
<?php } 
#Desabilitar error cuando carguen web.
$_SESSION['TengoError'] = false; 
$_SESSION['errorID'] = 0; 
?>
<div class="t-m1 alert-box">
    <p class="alert alert-info">En este sitio web no hay filtros puedes publicar lo que quieras. <b>Att: Admin</b></p>
</div>
<div class="t-m1 alert-box">
    <p class="alert alert-warning">Estás viendo confesiones de <strong>personas de todo el mundo </strong> 🌎</p>
</div>
<div class="container" data-result="confesiones-loader">
    <div class="loader-container"><div class="loader">Loading...</div></div>
</div>
<div class="container" data-result="confesiones">
</div>
<div class="container" data-result="no-more-results">
</div>
<?php
#SISTEMA DE REPORTAR
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
    if (empty($ip_actual)) {
        $ip_actual = $_SERVER['REMOTE_ADDR'];
    }
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
        echo '';
?>
<?php
exit();
    #Validamos que no este vacio la casilla id_conf
    } if ($id_actual == NULL) {
        echo '';
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
    ?>
<?php }}?>