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
    if ($rangouser == "2") {
      header("Location: dashboard");
    }
    if ($rangouser == "3") {
   header("Location: dashboard");
    }

    
    #Hacemos consulta a la base de datos
    $consulta2 = $conn->query("SELECT * FROM equipo ORDER BY rank DESC");

?>
<div class="container-fluid pt-4 px-4">
   <div class="row g-4">
      <div class="col-12">
         <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4"><i class="bi bi-user"></i> Usuarios del panel</h6>
            <div class="table-responsive">
               <table class="table">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Rango</th>
                        <th scope="col">Accion</th>
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
                      
                    ?>
                     <tr>
                        <td scope='row'><?php echo $conf['id']; ?></td>
                        <td><?php echo $conf['username']; ?></td>
                        <td><?php echo $rango ?></td>
                        <td><a href="<?php echo "system/eliminar/borrar-usu?id=" . $conf['id']; ?>"><i class="bi bi-trash"></i> Borrar</a></td>
                     </tr>
                  </tbody>
                  <?php }}?>
               </table>
            </div>
         </div>
      </div>
   </div>
<?php include('templates/footer.php'); ?>