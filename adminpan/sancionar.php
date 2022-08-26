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
    #Cargar html
    include('templates/head.php');
    include('templates/navbar.php');
?>
<div class="container-fluid">
   <div class="row h-100 align-items-center justify-content-center">
      <div class="col-sm-12 col-xl-6">
         <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
         <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="text-primary"><i class="bi bi-shield-fill-x"></i> SANCIONAR</h3>
                </div>
            <form method="POST" action="system/env-sancion.php">
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="ip">
                  <label for="floatingInput">Direccion IP</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Usuario" name="razon">
                  <label for="floatingInput">Razon de la sanción</label>
               </div>
               <div class="form-floating mb-4">
                    <input type="date" name="fin" class="form-control">
                    <label for="floatingInput">Tiempo de sancion</label>
               </div>
               <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Sancionar</button>
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