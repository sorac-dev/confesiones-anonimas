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
    include('templates/head.php');
    include('templates/navbar.php');

    #Hacemos consulta a la base de datos
    $consulta = $conn->query("SELECT COUNT(*) FROM conf_respuestas");
    #Solicitara la cantidad de registros en la tabla seleccionada anteriormente.
    $cantidad_conf = $consulta->fetch()[0];

    //Comienza consultas de busqueda
    $consulta = "SELECT * FROM conf_respuestas";
    $busqueda = null;

    if (isset($_GET["buscar"])) {
        $busqueda = $_GET["buscar"];
        $consulta = "SELECT * FROM conf_respuestas WHERE id = $busqueda";
    }
    $sentencia = $conn->prepare($consulta, [
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
    ]);

    if ($busqueda === null) {
        $sentencia->execute();
    } else {
        $parametros = ["%$busqueda%"];
        $sentencia->execute($parametros);
    }
    //Termina consulta de busqueda
?>
<div class="container-fluid">
   <div class="row h-100 align-items-center justify-content-center">
      <div class="col-sm-12 col-xl-6">
         <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
         <div class="d-flex align-items-center justify-content-between mb-3">
                    <h3 class="text-primary"><i class="bi bi-search"></i> BUSCAR CONFESION</h3>
                </div>
            <form method="GET" action="confesiones">
               <div class="form-floating mb-3">
                  <input type="text" class="form-control" id="floatingInput" placeholder="Confesion ID" name="buscar">
                  <label for="floatingInput">Confesion ID</label>
               </div>
               <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Buscar confesion</button>
            </form>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-12">
         <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"><i class="bi bi-exclamation-octagon"></i> Lista de confesiones</h6>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Confesión</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Pais</th>
                        <th scope="col">IP usuario</th>
                        <th scope="col">Accion</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php while ($conf = $sentencia->fetchObject()) {?>
                     <tr>
                        <td scope='row'><?php echo $conf->id ?></td>
                        <td><?php echo $conf->edad ?></td>
                        <td><?php echo $conf->confesion ?></td>
                        <td><?php echo $conf->date_conf ?></td>
                        <td><?php echo $conf->pais ?></td>
                        <td><?php echo $conf->ip_user ?></td>
                        <td><a href="<?php echo "system/eliminar/borrar-conf?id=" . $conf->id ?>"><i class="bi bi-trash"></i> Borrar</a></td>
                     </tr>
                  </tbody>
                  <?php }}?>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php include('templates/footer.php'); ?>