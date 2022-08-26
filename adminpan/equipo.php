<?php
require('core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    exit();
} else {
    include('templates/head.php');
    include('templates/navbar.php');

    #Validacion de rangos
    $mi_id    = $_SESSION['id'];

    $consulta = $conn->query('SELECT * FROM equipo WHERE id = "' . $mi_id . '"');
    while ($datos = $consulta->fetch()) {
        $rangouser = $datos['rank'];
    }

    if ($rangouser == "1") {
        header("Location: dashboard");
    }
    
    #Hacemos consulta a la base de datos
    $consulta2 = $conn->query("SELECT * FROM equipo ORDER BY rank DESC");
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
                        <th scope="col">Nombre</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Pais</th>
                        <th scope="col">Fecha registro</th>
                     </tr>
                  </thead>
                  <tbody>
                  <?php
                  while ($conf = $consulta2->fetch()) {  
                      if ($conf['rank'] == 1) {
                          $rango = "Invitado";
                      }
                      if ($conf['rank'] == 2) {
                        $rango = "Moderador";
                      }
                      if ($conf['rank'] == 3) {
                        $rango = "Supervisor";
                      }
                      if ($conf['rank'] == 4) {
                        $rango = "Administrador";
                      }
                      $username = $conf['username'];
                      $onlines = $conn->query("SELECT logeado FROM equipo WHERE username = '$username'");
                     while($data = $onlines->fetch()) {
                        if ($data['logeado'] == "0") {
                           $estoy = '<i class="bi bi-broadcast-pin" style="color:red;" title="Desconectado"></i>';
                        }
                        if ($data['logeado'] == "1") {
                           $estoy = '<i class="bi bi-broadcast-pin" style="color:green;" title="Conectado"></i>';;
                        }
                    ?>
                     <tr>
                        <td scope='row'><?php echo $conf['id']; ?></td>
                        <td><?php echo $conf['username']; ?> <?=$estoy?></td>
                        <td><?php echo $rango ?></td>
                        <td><?php echo $conf['pais']; ?></td>
                        <td><?php echo $conf['fecha_registro']; ?></td>
                     </tr>
                  </tbody>
                  <?php }}}?>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php include('templates/footer.php'); ?>