<?php
if (isset($_POST['password']) && isset($_POST['username']) && isset($_POST['repeat-password']) && isset($_POST['id-invitacion'])) {
    require('../core/server.php');

    #Datos que necesitaremos luego
    $username = htmlentities($_POST['username']);
    $fecha = date('d-M-Y h:i:s', time());
    $password = $_POST['password'];
    $r_password = $_POST['repeat-password'];
    $codigo = $_POST['id-invitacion'];

    #Ciframos contraseña
    $cifrado1 = sha1($_POST['password']);
    $pass_cifrada = md5($cifrado1);

    #Direccion IP y Pais
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];

    #Fechas para log
    $fecha= date('d-M-Y', time());
    $time = date('h:i', time());
    $fecha_all = date("Y-m-d h:i:s", time());


    #Verificamos que las contraseñas coinsidan
    if ($password != $r_password) {
        header("Location: ../registro/registro.php?errorPass");
?>
<?php
exit();
    }
    #Validacion de que no esten acias las casillas de password
    if ($password == NULL && $r_password == NULL) {
        header("Location: ../registro.php?contraseñas-vacias");
?>
<?php
exit();
    }
    #Validacion de usuario si existe o no
    $consulta = $conn->query("SELECT * FROM equipo WHERE username = '".$_POST['username']."'");
    $row = $consulta->fetch();

    if ($row && $row['username'] == $username) {
        header("Location: ../registro.php?errorUser");
?>
<?php
exit();
    }
    #Validacion de que no este vacia la casilla usuario
    if ($username == NULL) {
        header("Location: ../registro.php?usuarioVacio");
?>
<?php
exit();
    }
    #Consultar a la base de datos de invitaciones
    $consulta2 = $conn->query("SELECT * FROM invitacion WHERE codigo = '".$_POST['id-invitacion']."'");
    $data = $consulta2->fetch();

    #Validar si esta usado o no
    if ($data['usado'] == "1") {
        header("Location: ../registro.php?codigoUsado");
?>
<?php
exit();
    }
    #Validar que no este vacio la casilla de codigo de invitacion
    if ($codigo == NULL) {
        header("Location: ../registro.php?codigoVacio");
?>
<?php
exit();
    }
    #Validar que exista el codigo
    if ($codigo == $data['codigo']) {

    #Enviar datos a la base de datos
    $consulta3 = $conn->query("INSERT INTO equipo (username, password, ip, pais, fecha_registro) VALUES ('{$username}','{$pass_cifrada}', '{$ip}', '{$pais}', '{$fecha_all}')");

    #Actualizar codigo invitacion
    $usar = "1";

    #Actualizar a estado usado el codigo de invitacion
    $update_invi = $conn->query("UPDATE invitacion SET usado='$usar' WHERE codigo = '$codigo'");

    #Guardado logs
    $accion = "se registro en el panel administrativo";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username."','".$accion."','".$fecha_all."')";
    $conn->query($enviar_log);

    session_start(); 
    session_unset();
    session_destroy(); 
    setcookie("id","x",time()-3600,"/");
    header("Location: ../login");

?>
<?php
exit();
    } else {
        header("Location: ../registro.php?no-code");
?>
?>

<?php }} ?>
<?php echo header("Location: ../registro.php?no-existe-codigo"); ?>