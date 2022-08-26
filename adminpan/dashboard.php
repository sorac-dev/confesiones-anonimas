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
    $mi_id = $_SESSION['id'];
    $consulta = $conn->query('SELECT rank FROM equipo WHERE id = "'.$mi_id.'"');
    while ($datos = $consulta->fetch()) {
        $rangouser = $datos['rank'];
    }

    //Comienza consulta de estadisticas

    #Hacemos consultas a la base de datos
    $consulta = $conn->query("SELECT COUNT(*) FROM conf_respuestas");
    $consulta2 = $conn->query("SELECT COUNT(*) FROM reportes");

    $consulta3 = $conn->query("SELECT COUNT(*) FROM logs_conf");
    $consulta4 = $conn->query("SELECT COUNT(*) FROM logs_login");
    $consulta5 = $conn->query("SELECT COUNT(*) FROM logs_moderacion");
    $consulta6 = $conn->query("SELECT COUNT(*) FROM logs_reportes");
    $consulta7 = $conn->query("SELECT COUNT(*) FROM logs_sospechosos");

    #Solicitara la cantidad de registros en la tabla seleccionada anteriormente.
    $stats_conf = $consulta->fetch()[0];
    $stats_reportes = $consulta2->fetch()[0];

    #Suma de registros
    $l1 =  $consulta3->fetch()[0];
    $l2 =  $consulta4->fetch()[0];
    $l3 =  $consulta5->fetch()[0];
    $l4 =  $consulta6->fetch()[0];
    $l5 =  $consulta7->fetch()[0];
    $stats_logs = $l1 + $l2 + $l3 + $l4 + $l5;

    #Consulta confesiones
    $confesiones = $conn->query("SELECT * FROM `conf_respuestas` ORDER BY `conf_respuestas`.`id` DESC LIMIT 5");
?>
<!-- Estadisticas totales -->
<div class="container-fluid pt-4 px-4">
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="fa fa-exclamation-circle me-2"></i> Recuerda que toda actividad indebida como moderador del sitio, sera por mal vista por tus superiores y podrias ser sancionado o expulsado permanentemente del equipo confesiones.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <div class="alert alert-warning" role="alert">
      Querido moderador, este panel esta constantemente en mejoramiento. Si encuentra algun bug o error por favor comunicarse con el web master, para solucionarlo lo antes posible y asi evitar fallas de seguridad.
   </div>
   <div class="row g-4">
      <div class="col-sm-6 col-xl-3">
         <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-line fa-3x text-primary"></i>
            <div class="ms-3">
               <p class="mb-2">Confesiones</p>
               <h6 class="mb-0"><?=$stats_conf?></h6>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-3">
         <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-bar fa-3x text-primary"></i>
            <div class="ms-3">
               <p class="mb-2">Reportes</p>
               <h6 class="mb-0"><?=$stats_reportes?></h6>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-3">
         <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-area fa-3x text-primary"></i>
            <div class="ms-3">
               <p class="mb-2">Visitantes</p>
               <h6 class="mb-0">No disponible</h6>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-3">
         <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
            <i class="fa fa-chart-pie fa-3x text-primary"></i>
            <div class="ms-3">
               <p class="mb-2">Total logs</p>
               <h6 class="mb-0"><?=$stats_logs?></h6>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Fin estadisticas -->
<!-- Confesiones recientes -->
<div class="container-fluid pt-4 px-4">
   <div class="bg-light text-center rounded p-4">
      <div class="d-flex align-items-center justify-content-between mb-4">
         <h6 class="mb-0">Últimas 5 confesiones</h6>
         <a href="">Ver todas</a>
      </div>
      <div class="table-responsive">
         <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
               <tr class="text-dark">
                  <th scope="col">#</th>
                  <th scope="col">ID confesión</th>
                  <th scope="col">Confesión</th>
                  <th scope="col">Genero</th>
                  <th scope="col">Pais</th>
                  <th scope="col">Hora</th>
               </tr>
            </thead>
            <?php while ($conf = $confesiones->fetch()) {
                if ($conf['genero'] == 2) {
                    $genero = "Anonimo";
                }
                if ($conf['genero'] == 3) {
                    $genero = "Chica";
                }
                if ($conf['genero'] == 4) {
                    $genero = "Chico";
                }
                $confesion = $conf['confesion'];
                ?>
            <tbody>
               <tr>
                  <td><?=$conf['id']?></td>
                  <td><?=$conf['id_conf']?></td>
                  <td><?php echo substr($confesion, 0, 85)?>...</td>
                  <td><?=$genero?></td>
                  <td><?=$conf['pais']?></td>
                  <td><?=$conf['time_conf']?></td>
               </tr>
            </tbody>
            <?php } ?>
         </table>
      </div>
   </div>
</div>
<!-- Recent Sales End -->
<div class="container-fluid pt-5 px-5">
   <div class="bg-light rounded h-100 p-4">
      <h6 class="mb-4"><i class="bi bi-info-circle"></i> Informacion importante</h6>
      <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
         <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
               data-bs-target="#pills-reglas" type="button" role="tab" aria-controls="pills-home"
               aria-selected="true">Reglas</button>
         </li>
         <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
               data-bs-target="#pills-profile" type="button" role="tab"
               aria-controls="pills-profile" aria-selected="false" style="display: none;">Profile</button>
         </li>
      </ul>
      <div class="tab-content" id="pills-tabContent">
         <div class="tab-pane fade show active" id="pills-reglas" role="tabpanel" aria-labelledby="pills-home-tab">
            <b style="color: red;">Reglas principales del panel administrativo</b>
           <ul>
              <li>No sancionar a ninguna direccion ip si no es necesario.</li>
              <li>No borrar confesiones si no incumplen las normas.</li>
              <li>No compartir información comprometedora del panel o usuarios.</li>
              <li>No compartir tu cuenta de moderador con nadie.</li>
              <li>Si vas atender una denuncia, recuerda que necesitas conocer bien las reglas <br>
               para poder ejercer alguna acción contra alguna confesion o usuario.</li>
           </ul>
         </div>
         <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            Invidunt rebum voluptua lorem eirmod dolore. Amet no sed sanctus lorem ea. Nonumy sit stet sit magna. Rebum rebum ipsum clita erat consetetur, sit dolor sit clita et amet. Est et clita dolore takimata, sea dolores tempor erat consetetur lorem. Consetetur sea sadipscing dolor et dolores et stet, tempor elitr.
         </div>
         <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            Et diam et est sed vero ipsum voluptua dolor et, sit eos justo ipsum no ipsum amet sed aliquyam dolore, ut ipsum sanctus et consetetur. Sit ea sit clita lorem ea gubergren. Et dolore vero sanctus voluptua ipsum sadipscing amet at. Et sed dolore voluptua dolor eos tempor, erat amet.
         </div>
      </div>
   </div>
</div>

<?php include('templates/footer.php'); ?>
<?php } ?>