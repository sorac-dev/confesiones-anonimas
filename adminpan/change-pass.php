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
   </div>
</div>
<?php
}
?>
<?php
include('templates/footer.php');
?>