<?php
require('./core/server.php');
?>
<?php
$consulta = $conn->query("SELECT * FROM `conf_respuestas` ORDER BY `conf_respuestas`.`id` DESC");
while($row = $consulta->fetch()) {
    if ($row['genero'] == 2) {
        $genero = "user-secret";
        $disable = "style='display:none;'";
    }
    if ($row['genero'] == 3) {
        $genero = "female";
        $disable = "";
    }
    if ($row['genero'] == 4) {
        $genero = "male";
        $disable = "";
    }
    if ($row['pais'] == is_null($row['pais'])) {
        $pais = strtolower("unknown");
    }
    if ($row['pais'] == $row['pais']) {
        $pais = strtolower($row['pais']);
    }
?>
    <div class="conf-separador"></div>
    <div class="container-conf" id-confesion="<?php echo "$row[id_conf]"; ?>">
        <div class="div-confesion-<?php echo "$genero"; ?>">
            <div class="conf-head-<?php echo "$genero"; ?>">
                <div class="conf-edad-h aling-left">
                    <i class="fa fa-<?php echo "$genero"; ?>" aria-hidden="true"></i><span> <?php echo "$row[edad]"; ?> </span>años
                </div>
            </div>
            <div class="conf-meta">
                <i class="fa fa-history" aria-hidden="true"></i> <?php echo "$row[time_conf]"; ?> <span class="text-flag aling-right" <?php echo "$disable"; ?>><img src="/assets/images/flags/<?php echo "$pais"; ?>.svg"> <?php echo "$row[pais]"; ?></span>
            </div>
            <div class="conf-contenido">
                <?php echo "$row[confesion]"; ?>
            </div>
            <form class="conf-footer" method="POST" action="../templates/funciones/reportar.php">
                <input type="hidden" name="id_post" value="<?php echo "$row[id_conf]"; ?>">
                <input type="submit" class="text-report aling-right" value="Reportar"/>
            </form>
        </div>
    </div>
    <?php } ?>
