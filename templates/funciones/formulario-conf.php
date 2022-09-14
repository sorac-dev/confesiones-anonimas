<?php
require('./core/server.php');
session_start();
?>
<div class="form-conf" id="escribir" style="display: none;">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-bar">
            <label for="edad">Tengo</label>
            <input type="number" name="edad" id="" placeholder="Edad" require class="input-conf" min="13" max="99"/>
            <label for="genero">años y soy</label>
            <select name="genero" id="" require class="input-conf">
                <option value="2">anonimo</option>
                <option value="3">mujer</option>
                <option value="4">hombre</option>
            </select>
        </div>
        <div class="textarea-justify">
            <textarea class="form-textarea" name="confesion" id="" cols="30" rows="10" maxlength="420" placeholder="Escribe tu confesion..."></textarea>
        </div>
        <div class="form-bar">
        <input type="submit" value="Enviar" class="btn-form">
        </div>
    </form>
</div>
<?php
if ((isset($_POST['edad'])) && (isset($_POST['genero']))  && (isset($_POST['confesion']))) {
    $age_validar   = ( empty($_POST['edad']) )   ? NULL : $_POST['edad']; //Validar que no este vacio
    $conf   = ( empty($_POST['confesion']) )   ? NULL : $_POST['confesion']; //Validar que no  este vacio

    $cargar = $conn->query("SELECT * FROM conf_respuestas");
    $dConf2 = $cargar->fetch();

    $n_rand = rand();

    #Volver caracteres especiales
    $conf_f3 = strip_tags($conf);
    $confe_f2 = htmlspecialchars($conf_f3);
    $confe = html_entity_decode($confe_f2);

    #Validar edad
    $age = strip_tags($age_validar);

    //Fecha log
    $fecha_log = date('d-M-Y', time());
    $time_log = date('h:i', time());

    //Direccion ip y el pais
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

    #Validaciones de texto del genero
    $genero_v2 = strip_tags($_POST['genero']);
    $genero = htmlentities($genero_v2);

    #Verificamos que este activo confesiones
    $cons = $conn->query("SELECT * FROM config WHERE id='1'");
    $dataConf = $cons->fetch();

#Validamos confesion
if (!$age || !$conf || $age >= '100' || $age <= '2' || $genero >= '5' || $genero <= '1' || empty(($conf))) {

    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 1;
    header("Location: ../index");
?>
<?php 
exit();
} if ($dataConf['confesiones'] == "0") {

    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 2;
    header("Location: ../index");
?>
<?php    
exit(); 
} else {
    $durFormBloqueado = 3;
    if(isset($_SESSION['duracionFormBloqueado']) && $_SESSION['duracionFormBloqueado'] + $durFormBloqueado > time())
    {
    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 3;
    header("Location: ../index");
    ?>
    <?php
    exit();
    } else {
    #Enviar confesion
    $send = "INSERT INTO conf_respuestas (id_conf, edad, genero, confesion, date_conf, time_conf, pais, ip_user) values ('" . strip_tags($n_rand) . "','" . strip_tags($age) . "','" . strip_tags($genero) . "','" . $confe . "','" . strip_tags($fecha_log) . "', '" . strip_tags($time_log) . "','" . strip_tags($pais) . "','" . strip_tags($ip) . "')";
    $conn->query($send);

    #Datos
    $accion    = "$ip hizo una confesión.";
    $fecha_c = date("Y-m-d h:i:s", time());
    
    #Enviar a log moderacion
    $enviar_log = "INSERT INTO logs_conf (id_conf,accion,ip_user,fecha) values ('{$n_rand}','{$accion}','{$ip}','{$fecha_c}')";
    $conn->query($enviar_log);
    $_SESSION['duracionFormBloqueado'] = time(); // Se guarda la fecha en sesion
    $_SESSION['TengoError'] = false;
    header("Location: ../index");
?>
<?php }}} ?>