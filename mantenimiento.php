<?php
require('core/server.php');
?>
<?php 
#Vamos a ver si el sitio esta en mantenimiento
$config = $conn->query("SELECT * FROM config WHERE id='1'");
while($dataConf = $config->fetch()) {
    $mtni = $dataConf['mantenimiento'];
    $msg_mtni = $dataConf['msg_mtni'];
}



if ($mtni == "1") {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
<style>
body {
    background-color: #000;
}
.mtn {
    color: white;
    font-family: sans-serif;
    margin-right: auto;
    margin-left: auto;
    justify-content: center;
    position: relative;
    min-width: 200px;
    width: auto;
    max-width: 550px;
    border: 3px solid #0b0c42;
    border-radius: 12px;
}
.mtn-head {
    background-color: #191b8f;
    display: flex;
    justify-content: center;
    padding-left: 10%;
    padding-right: 10%;
}
.mtn-body {
    background-color: #040863;
    padding: 16px;
    font-size: 16px;
}
</style>
<br><br><br><br>
<div class="mtn">
    <div class="mtn-head">
        <h2>Estamos en mantenimiento</h2>
    </div>
    <div class="mtn-body">
        <p><?=$msg_mtni?></p>
        <br>
        <span><i class="bi bi-discord"style="color:#5865F2;" ></i> <a href="#" style="text-decoration: none; color:white; font-size:12px;"> Unete a nuestro discord
        </a></span>
        <br>
        <span><i class="bi bi-twitter"style="color:#00acee;" ></i> <a href="https://twitter.com/_confesanonimas" target="_blank" style="text-decoration: none; color:white; font-size:12px;">@_confesanonimas
        </a></span>
    </div>
</div>
</body>
</html>
<?php
 } else {
   header("Location: index");
 }
?>