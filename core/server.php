<?php
/*
* Esta funcion formatea en JSON
*/
if (!function_exists('jsonencode')){
  function jsonencode($array = [], $options = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT, $header = "Content-type: application/json; charset=utf-8")
  {
      header($header);
      $json = json_encode($array, $options);
      if ($json === false) {
          $json = json_encode(["jsonError" => json_last_error_msg()], $options);
          if ($json === false) {
              // This should not happen, but we go all the way now:
              $json = '{"jsonError":"unknown"}';
          }
          // Set HTTP response status code to: 500 - Internal Server Error
          http_response_code(500);
      }
      return $json;
  }
}

$servername = "localhost";
$username = "root";
$password = "";
$database ="confesiones";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // Se establece error de conexion del PDO
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Conexion correcta.";
} catch(PDOException $e) {
  echo "Conexión fallida: " . $e->getMessage();
}

#Zona horaria por defecto de la pagina web
date_default_timezone_set("America/Bogota");

$ip_baneada = '';
$ip_actual = $_SERVER["REMOTE_ADDR"];

#Consultamos los baneos por ip
$resultado = $conn->query("SELECT * FROM baneos WHERE ip_ban = '$ip_actual'");
while ($row = $resultado->fetch()) {
  $ban_inicio = $row['fecha_inicio'];
  $ban_final = $row['fecha_fin'];
  $ip_baneada = $row['ip_ban'];
  $ban_razon = $row['razon'];
}

$fecha_hoy = date("Y-m-d");
if ($ip_actual == $ip_baneada) {

  #Desbaneo de cuenta
  if ("$fecha_hoy" >= $ban_final) {
    $unban_sql = "DELETE FROM baneos WHERE ip_ban='$ip_actual' LIMIT 1";
    $conn->query($unban_sql);
  }
  #Si sigue baneado
  if ("$fecha_hoy" != "$ban_final") {
    echo '
    <style>
    body {
        background-color: #f3f6f9;
    }
    .baneado {
        color: white;
        font-family: sans-serif;
        margin-right: auto;
        margin-left: auto;
        justify-content: center;
        position: relative;
        width: 30%;
        border: 3px solid #4d1010;
        border-radius: 12px;
    }
    .baneado-head {
        background-color: brown;
        display: flex;
        justify-content: center;
        padding-left: 10%;
        padding-right: 10%;
    }
    .baneado-body {
        background-color: #802626;
        padding: 16px;
        font-size: 16px;
    }
    </style>
        
    <div class="baneado">
        <div class="baneado-head">
            <h2>Fuiste sancionado de la comunidad</h2>
        </div>
        <div class="baneado-body">
            <p>Usted fue sancionado de la comunidad, por lo tanto no tendra acceso a nuestro sitio temporalmente, si crees que fue algún error o fue injusto contacta con nuestro equipo de soporte mediante correo electronico (soporte.confesiones@gmail.com) o por nuestro discord directamente.</p>
            <p><b>Tu sanción durara una semana</b></p>
        </div>
    </div>';
    exit();
  }

}

#Vamos a ver si el sitio esta en mantenimiento
$config = $conn->query("SELECT * FROM config WHERE id='1'");
$dataConf = $config->fetch();
$msg_mtni = $dataConf['msg_mtni'];
if ($dataConf['mantenimiento'] == "1") {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confesiones - Mantenimiento</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

</head>
<style>
body {
    background-color: #000;
}
.mtn {
    margin-top: 4%;
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
<?php
 } else {
   echo '';
 }

?>