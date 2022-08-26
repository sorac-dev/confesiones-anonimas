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
            <form method="POST" action="system/ascender.php">
               <div class="form-floating mb-3">
                  <input class="form-control-sm mb-3" type="text" placeholder="Usuario" aria-label="Usuario" name="user">
               </div>
                <select class="form-select form-select-sm mb-3" aria-label=".form-select-sm example" name="rango">
                        <option selected="" disabled>Rango</option>
                        <option value="1">Invitado</option>
                        <option value="2">Moderador</option>
                        <option value="3">Supervisor</option>
                        <option value="4">Administrador</option>
                </select>
               <button type="submit" class="btn btn-primary m-2">Cambiar rango</button>
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