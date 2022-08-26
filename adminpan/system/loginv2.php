<?php
if (isset($_POST['password']) && isset($_POST['username'])) {
  require('../core/server.php');

    if ($_POST['username']) {
    $username = htmlentities($_POST['username']);
    $cifrado1 = sha1($_POST['password']);
    $password = md5($cifrado1);

    #Verificamos que no este vacio
    if ($password == NULL) {
        header("Location: ../login?error");
?>
<?php
    exit();
        }else {
            $consulta = $conn->query("SELECT username,password FROM equipo WHERE username = '$username'");
            $data =  $consulta->fetch();
            if ($data['password'] != $password) {
                header("Location: ../login?error");
?>
<?php
    exit();
} else {
    $consult = $conn->query("SELECT id,username,password FROM equipo WHERE username = '$username'");
    $row =  $consult->fetch();
    
    $_SESSION["username"] = $row['username'];
    $_SESSION["id"] = $row['id'];
    $_SESSION["logeado"]  = "SI";

    #Ultima vez
    $last_fecha = date('d-M-Y h:i:s', time());
    $last_ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $last_pais = $_SERVER["HTTP_CF_IPCOUNTRY"];

    #Pais
    $lasted_pais = "UPDATE equipo SET last_pais = '$last_pais' WHERE username like'" .$username. "'";
    $sed_pais = $conn->query($lasted_pais);

    #IP
    $lasted_ip = "UPDATE equipo SET last_ip = '$last_ip' WHERE username like'" .$username. "'";
    $sed_pais = $conn->query($lasted_ip);

    #Fecha
    $lasted_fecha = "UPDATE equipo SET last_date = '$last_fecha' WHERE username like'" .$username. "'";
    $sed_pais = $conn->query($lasted_fecha);

    #Actualizamos su estado
    $logeado ='1';
    $update_invi = $conn->query("UPDATE equipo SET logeado='$logeado' WHERE username = '$username'");

    #Datos
    $fecha_log = date("Y-m-d h:i:s", time());
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "ha iniciado sesión";

    #Enviar a log login
    $enviar_log = "INSERT INTO logs_login (user_login,accion,pais_login,ip_login,fecha) values ('{$username}','{$accion}','{$pais}','{$ip}','{$fecha_log}')";
    $conn->query($enviar_log);

    #Revisamos si entra de un ip deferente
    $revisar = $conn->query("SELECT * FROM equipo WHERE username = '{$username}'");
    while ($row = $revisar->fetch()) {
      $ip_original = $row['ip'];
      $pais_original = $row['pais'];
    }

    #Verificar que sea la misma ip
    if ($ip == $ip_original) {
      echo '';
    } else {
      $sos_msg = "Ha iniciado sesión con otra ip (La cuenta No a sido bloqueada)";
      $sosp_ip = "INSERT INTO logs_sospechosos (user_logeado,accion,ip,pais,fecha) values ('{$username}','{$sos_msg}','{$ip}','{$pais}','{$fecha_log}')";
      $conn->query($sosp_ip);
    }

    #Verficar que sea del mismo pais
    if ($pais == $pais_original) {
      echo '';
    } else {
      $sos_pais_msg = "Ha iniciado sesión desde otro pais (La cuenta No a sido bloqueada)";
      $sosp_pais = "INSERT INTO logs_sospechosos (user_logeado,accion,ip,pais,fecha) values ('{$username}','{$sos_pais_msg}','{$ip}','{$pais}','{$fecha_log}')";
      $conn->query($sosp_pais);
    }
?>
<script type="text/javascript">
  location.href ="../index?iniciado";
</script>
<?php
            }
        }
    }
}
?>
<script type="text/javascript">
  location.href ="../login";
</script>