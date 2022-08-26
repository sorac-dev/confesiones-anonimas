<?php
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
if ($dataConf['mantenimiento'] == "1") {
  header("Location: mantenimiento");
 } else {
   echo '';
 }

?>