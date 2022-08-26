<?php
$consulta = $conn->query("SELECT * FROM config");
while($row = $consulta->fetch()) {
$nameweb =  $row['nameweb'];
$descripcion = $row['descripcion'];
$image_og = $row['image_og'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">
    <meta name="og:description" content="<?php echo "$descripcion" ?>">
    <meta property='og:site_name' content='<?php echo "$nameweb" ?>'/>
    <meta property='og:image' content='<?php echo "$image_og" ?>'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$nameweb" ?></title>
    <link rel="stylesheet" href="./app/css/styles.css">
    <script src="./app/js/jquery-3.6.0.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.2.0/css/fork-awesome.min.css" integrity="sha256-XoaMnoYC5TH6/+ihMEnospgm0J1PM/nioxbOUdnM8HY=" crossorigin="anonymous">
    
</head>
<?php } ?>