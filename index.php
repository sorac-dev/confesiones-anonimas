<?php
require_once('./core/server.php');
#Vamos a ver si el sitio esta en mantenimiento
$config = $conn->query("SELECT * FROM config WHERE id='1'");
$dataConf = $config->fetch();
if ($dataConf['mantenimiento'] != "1") {
include('./templates/head.php');
include('./templates/header.php');
include('./templates/Body-Index.php');
include('./templates/footer.php');
} else {
    '';
}
?>