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
?>

<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    $consulta = $conn->query("SELECT * FROM equipo WHERE username ='".!isset($_SESSION['username'])."'");
    while ($row= $consulta->fetch()) {
      $username = $row['username'];
    }
?>