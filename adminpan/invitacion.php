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
    include('templates/head.php');
    include('templates/navbar.php');

    #Hacemos consulta a la base de datos
    $consulta2 = $conn->query("SELECT * FROM invitacion ORDER BY `invitacion`.`id` DESC");
?>
<div class="container-fluid">
   <div class="row h-100 align-items-center justify-content-center">
      <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
          <br><br><br>
            <form method="POST" action="system/g-codigo96">
               <button type="submit" class="btn btn-primary py-3 w-100 mb-4" name="generar">Generar codigo</button>
            </form>
      </div>
   </div>
</div>
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-12">
         <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"><i class="bi bi-pencil-square"></i> Lista de confesiones</h6>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Usado</th>
                        <th scope="col">Fecha y hora de creación</th>
                        <th scope="col">Accion</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php while ($conf = $consulta2->fetch()) {
                      if ($conf['usado'] == 1) {
                        $usado = "Si";
                     }  elseif($conf['usado'] == 0) {
                         $usado = "No";
                     }?>
                     <tr>
                        <td scope='row'><?php echo $conf['id']; ?></td>
                        <td><?php echo $conf['codigo']; ?></td>
                        <td><?php echo $usado ?></td>
                        <td><?php echo $conf['fecha_creacion']; ?></td>
                        <td><a href="<?php echo "system/eliminar/borrar-invi?id=" . $conf['id'] ?>"><i class="bi bi-trash"></i> Borrar</a></td>
                     </tr>
                  </tbody>
                  <?php }}?>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php include('templates/footer.php'); ?>