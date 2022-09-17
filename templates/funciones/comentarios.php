<?php
require('./core/server.php');
?>
<div class="container">
<?php 
    $id_post = strip_tags(htmlentities($_GET['id']));
    $consulta = $conn->query("SELECT * FROM comentarios WHERE id_conf = $id_post ORDER BY `comentarios`.`id` DESC");
    while ($row = $consulta->fetch()) {
        if ($row['genero'] == 2) {
            $genero = "anonimo";
            $disable = "style='display:none;'";
        }
        if ($row['genero'] == 3) {
            $genero = "mujer";
            $disable = "";
        }
        if ($row['genero'] == 4) {
            $genero = "hombre";
            $disable = "";
        }
        if ($row['pais'] == $row['pais']) {
            $pais = strtolower($row['pais']);
        }
?>
  <div class="bg-com bg-body-<?php echo "$genero"; ?>">
    <img src="/assets/images/avatares/<?php echo "$genero"; ?>.png" class="com-avatar">
    <div class="cont-com">
      <p> <?php echo "$row[comentario]"; ?></p>
      <div class="com-footer">
        <span><i class="fa fa-history" aria-hidden="true"></i> <?php echo "$row[fecha]"; ?> <img <?=$disable?> src="/assets/images/flags/<?php echo "$pais"; ?>.svg"> <b style="float:right;">«<?php echo "$row[edad]"; ?> años»</b></span>
    </div>
    </div>
    <form method="POST" action="">
      <input type="hidden" name="id_post" value='3'>
      <button type="submit" class="btn-reportar-com aling-right" title="Reportar comentario"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
      <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
    </svg></button>
  </form>
  </div>
  <div class="conf-separador"></div>
<?php }  ?>
</div> 
