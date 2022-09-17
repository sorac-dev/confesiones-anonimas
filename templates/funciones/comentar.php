<?php
require('./core/server.php');
?>
<?php
if (empty($_GET['id'])) {
    $_GET['id'] = 0;
}
#Tomamos la id del GET y la validamos para la consulta
$id_post = strip_tags(htmlentities($_GET['id']));
?>
<div class="form-conf" id="escribir">
  <div class="form-bar com-head noselect">Comenta la confesión <b>@<?=$id_post?></b></div>
  <form action="" method="post" enctype="multipart/form-data">
      <div class="form-bar">
          <label for="edad">Tengo</label>
          <input type="number" name="edad" id="" require class="input-conf max-input" min="13" max="99"/>
          <label for="genero">años y soy</label>
          <select name="genero" id="" require class="input-conf">
              <option value="2">anonimo</option>
              <option value="3">mujer</option>
              <option value="4">hombre</option>
          </select>
      </div>
      <div class="textarea-justify">
          <textarea class="form-textarea" name="comentario" id="" cols="30" rows="10" maxlength="420" placeholder="¿Cual sera tu comentario?"></textarea>
      </div>
      <div class="form-bar">
      <button type="submit" class="btn-form"> <i class="bi bi-send-fill"></i> Enviar comentario</button>
      </div>
    </form>
</div>
<?php
if ((isset($_POST['edad'])) && (isset($_POST['genero']))  && (isset($_POST['comentario']))) {

    $age_validar   = ( empty($_POST['edad']) )   ? NULL : $_POST['edad']; //Validar que no este vacio
    $com   = ( empty($_POST['comentario']) )   ? NULL : $_POST['comentario']; //Validar que no  este vacio

    $segundos = date('i', time());
    $numero_aleatorio = rand(10000000,99999999);
    $n_rand = $numero_aleatorio + $segundos;

    #Volver caracteres especiales
    $com_f3 = strip_tags($com);
    $com_f2 = htmlspecialchars($com_f3);
    $comentario = html_entity_decode($com_f2);

    #Validar edad
    $age = strip_tags($age_validar);

    //Fecha log
    $fecha_log = date('d-M-Y', time());
    $time_log = date('h:i', time());
    $time = time();

    //Direccion ip y el pais
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

    if (empty($pais)) {
        $pais = 'desconocido';
    }
    if (empty($ip)) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    
    #Validaciones de texto del genero
    $genero_v2 = strip_tags($_POST['genero']);
    $genero = htmlentities($genero_v2);

    #Verificamos que este activo confesiones
    $cons = $conn->query("SELECT * FROM config WHERE id='1'");
    $dataConf = $cons->fetch();

#Validamos confesion 
if (!$age || !$comentario || $age >= '100' || $age <= '2' || $genero >= '5' || $genero <= '1' || empty(($comentario))) {

    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 1;
?>
<?php 
exit();
} if ($dataConf['confesiones'] == "0") {

    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 2;
?>
<?php    
exit(); 
} else {
    $durFormBloqueado = 3;
    if(isset($_SESSION['duracionFormBloqueado']) && $_SESSION['duracionFormBloqueado'] + $durFormBloqueado > time())
    {
    $_SESSION['TengoError'] = true;
    $_SESSION['errorID'] = 3;
    ?>
    <?php
    exit();
    } else {
    #Enviar confesion
    $sql = "INSERT INTO comentarios (id_conf, comentario, edad, genero, fecha, pais, ip) values ('".strip_tags($id_post)."','".strip_tags($comentario)."', '".strip_tags($age)."', '".strip_tags(($genero))."', '$time_log', '$pais', '$ip')";
    $conn->query($sql);

    #Datos
    $accion    = "$ip hizo un comentario.";
    $fecha_c = date("Y-m-d h:i:s", time());
    
    #Enviar a log moderacion
    $enviar_log = "INSERT INTO logs_conf (id_conf,accion,ip_user,fecha) values ('{$id_post}','{$accion}','{$ip}','{$fecha_c}')";
    $conn->query($enviar_log);
    $_SESSION['duracionFormBloqueado'] = time(); // Se guarda la fecha en sesion
    $_SESSION['TengoError'] = false;
?>
<?php }}} ?>
<div class="conf-separador"></div>
