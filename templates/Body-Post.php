<?php
require('./core/server.php');
?>
<?php
if (empty($_GET['id'])) {
    $_GET['id'] = 0;
}
#Tomamos la id del GET y la validamos para la consulta
$id_post = strip_tags(htmlentities($_GET['id']));

#Hacemos consulta a la base de datos.
$consulta = $conn->query("SELECT * FROM conf_respuestas WHERE id_conf = $id_post");
$row = $consulta->fetch();

$consulta = $conn->query("SELECT COUNT(*) FROM comentarios WHERE id_conf = $id_post");
$total_com = $consulta->fetch()[0];

#Hacemos justifiaciones de genero y pais.
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
if ($row['pais'] == $row['pais']) {
    $pais = strtolower($row['pais']);
}

#Verificamos que exista la confesion mediante su id real.
$id_real = $row[0] ?? false;

#Vamos a validar que exista esta confesion, si no existe lo enviara a index.
if (!$id_real) {
    header("Location: ../");
?>
<?php 
} else {
?>
<div class="conf-separador"></div>
    <div class="container-conf" id-confesion="<?php echo "$row[id_conf]"; ?>">
        <div class="div-confesion-<?php echo "$genero"; ?>">
        <div class="conf-head-<?php echo "$genero"; ?>">
                <a class="confesion-id" href="post?id=<?php echo "$id_post";?>">@<?php echo "$id_post";?></a>
                <div class="conf-edad-h aling-left">
                    <i class="fa fa-<?php echo "$genero"; ?>" aria-hidden="true"></i><span> <b><?php echo "$row[edad]"; ?></b> </span>años
                </div>
            </div>
            <div class="conf-meta">
                <i class="fa fa-history" aria-hidden="true"></i> <?php echo "$row[time_conf]"; ?> <span class="text-flag aling-right" <?php echo "$disable"; ?>><img src="/assets/images/flags/<?php echo "$pais"; ?>.svg"><?php echo "$row[pais]"; ?></span>
            </div>
            <div class="conf-contenido">
                <?php echo "$row[confesion]"; ?>
            </div>
            <div class="conf-footer">
                <form method="POST" action="../templates/funciones/reportar.php">
                    <input type="hidden" name="id_post" value='<?php echo "$row[id_conf]"; ?>'>
                    <button type="submit" class="btn-reportar aling-right" title="Reportar confesion"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                  </svg></button>
                </form>
                <a class="comentario aling-left" href="post?id=<?php echo "$id_post";?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-text-fill" viewBox="0 0 16 16">
                <path d="M16 8c0 3.866-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.584.296-1.925.864-4.181 1.234-.2.032-.352-.176-.273-.362.354-.836.674-1.95.77-2.966C.744 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7zM4.5 5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7zm0 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z"/>
                </svg> <?=$total_com?></a>
            </div>
            
        </div>
</div>
<div class="conf-separador"></div>
<?php } ?>
<?php 
include ('./templates/funciones/comentar.php');
include ('./templates/funciones/comentarios.php');
?>