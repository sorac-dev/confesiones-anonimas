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
    $consulta = $conn->query("SELECT * FROM reportes ORDER BY reportes.`id` DESC");
?>
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-12">
         <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"><i class="bi bi-exclamation-octagon"></i> Confesiones reportadas</h6>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th>Accion</th>
                        <th scope="col">IP denunciante</th>
                        <th scope="col">IP denunciado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Atendida</th>
                        <th scope="col">Accion</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php while ($conf = $consulta->fetch()) {
                      if ($conf['estado'] ==  0) {
                        $estado = '<i class="bi bi-check-square"></i> No';
                      }
                      if ($conf['estado'] ==  1) {
                        $estado = '<i class="bi bi-check-square-fill"></i> Si';
                      }
                      ?>
                     <tr>
                        <td scope='row'><?php echo $conf['id']; ?></td>
                        <td><a href="<?php echo "./confesiones?buscar=" . $conf['id'] ?>"><i class="bi bi-search"></i> Buscar</a></td>
                        <td><?php echo $conf['ip_denunciante']; ?></td>
                        <td><?php echo $conf['ip_denunciado']; ?></td>
                        <td><?php echo $conf['fecha'] ?></td>
                        <td><?php echo $estado ?></td>
                        <td><a href="<?php echo "system/atender?id=" . $conf['id'] ?>"><i class="bi bi-check-square"></i> Atender</a></td>
                     </tr>
                  </tbody>
                  <?php }}?>
               </table>
            </div>
         </div>
      </div>
   </div>

<?php include('templates/footer.php'); ?>