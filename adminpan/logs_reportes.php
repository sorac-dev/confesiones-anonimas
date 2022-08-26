<?php
require('core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    exit();
} else {
   #Validacion de rangos
   $mi_id = $_SESSION['id'];
   $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "'.$mi_id.'"');
   while ($datos = $consulta->fetch()) {
       $rangouser = $datos['rank'];
   }
   if ($rangouser == "1") {
      header("Location: dashboard");
  }
    include('templates/head.php');
    include('templates/navbar.php');

    #Hacemos consulta a la base de datos
    $consulta2 = $conn->query("SELECT * FROM `logs_reportes` ORDER BY `logs_reportes`.`id` DESC");
?>
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-12">
         <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"><i class="bi bi-exclamation-octagon"></i> Lista de confesiones</h6>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">IP denunciante</th>
                        <th scope="col">Accion</th>
                        <th scope="col">fecha</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php while ($conf = $consulta2->fetch()) {?>
                     <tr>
                        <td scope='row'><?php echo $conf['id']; ?></td>
                        <td><?php echo $conf['ip_denunciante']; ?></td>
                        <td><?php echo $conf['accion']; ?></td>
                        <td><?php echo $conf['fecha']; ?></td>
                     </tr>
                  </tbody>
                  <?php }}?>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php include('templates/footer.php'); ?>