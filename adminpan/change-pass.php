<?php
require('core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    exit();
} else {
    #Validacion de rangos
    $mi_id    = $_SESSION['id'];
    $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "' . $mi_id . '"');
    while ($datos = $consulta->fetch()) {
        $rangouser = $datos['rank'];
    }
    if ($rangouser == "1") {
        header("Location: dashboard");
    }
    if ($rangouser == "2") {
        header("Location: dashboard");
    }
    if ($rangouser == "3") {
        header("Location: dashboard");
    }
    #Cargar html
    include('templates/head.php');
    include('templates/navbar.php');
?>
<div class="container-fluid">
   <div class="row h-100 align-items-center justify-content-center">
      <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
         <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
            <form method="POST">
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="username">
                  <label for="floatingInput">Nombre de usuario</label>
               </div>
               <div class="form-floating mb-4">
                  <input type="text" class="form-control" id="floatingPassword" placeholder="Nueva contraseña" name="new-pass">
                  <label for="floatingPassword">Nueva contraseña</label>
               </div>
               <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Cambiar contraseña</button>
            </form>
         </div>
      </div>
<?php
}
?>
<?php
if (isset($_POST['username']) && isset($_POST['new-pass'])) {

   #Datos necesarios
   $usuario = htmlentities($_POST['username']);
   $new_pass = htmlentities($_POST['new-pass']);

   #Consultamos todos los datos a la tabla de equipo.
   $query = $conn->query("SELECT * FROM equipo WHERE username = '".$usuario."'");
   $dataQuery = $query->fetch();
   $id_usuario = $dataQuery[0] ?? false;

   if (!$id_usuario) {
      echo '<hr>
      <div class="col-sm-12 col-xl-6">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <i class="fa fa-exclamation-circle me-2"></i> El usuario ingresado no existe.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onClick="window.location.href=change-pass"></button>
      </div>
      </div>';
   } else {
    #Ciframos contraseña
    $cifrado1 = sha1($new_pass);
    $pass_cifrada = md5($cifrado1);

    #Enviar el cambio de contraseña
    $queryChange = "UPDATE equipo SET password = '$pass_cifrada' WHERE id = '$id_usuario'";
    $conn->query($queryChange);

    echo '<hr>
    <div class="col-sm-12 col-xl-6">
    <div class="alert alert-success alert-dismissible fade show" role="alert">
       <i class="fa fa-exclamation-circle me-2"></i> Hiciste el cambio de contraseña correctamente!
       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    </div>
    ';

    #Log
    $fecha_log = date("Y-m-d h:i:s", time());
    $username2 = $_SESSION['username'];
    $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
    $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
    $accion = "cambio la contraseña de $usuario";
    $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('".$ip."','".$pais."','".$username2."','".$accion."','".$fecha_log."')";
    $conn->query($enviar_log);
   }
}
?>
   </div>
</div>
<?php
include('templates/footer.php');
?>