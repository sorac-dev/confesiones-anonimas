<?php
require('../core/server.php');
#Validacion de rangos
$mi_id = $_SESSION['id'];
$consulta = $conn->query('SELECT rank FROM equipo WHERE id = "' . $mi_id . '"');
while ($datos = $consulta->fetch())
{
    $rangouser = $datos['rank'];
}
if ($rangouser == "1")
{
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>
<?php
if (isset($_SESSION['logeado']) != "SI")
{
    exit();
}
else
{
    if (isset($_GET['id']))
    {
        #Datos
        $id = $_GET['id'];

        #Consultar a la base de datos
        $consulta = $conn->query("SELECT * FROM reportes WHERE id='$id'");
        while ($row = $consulta->fetch())
        {
            $e_actual = $row['estado'];
        }
        if ($e_actual == 1)
        {
            echo '<script>location.href="../reportes.php";</script>';
        }
        else
        {
            #Consulta de update
            $update = $conn->query("UPDATE reportes SET estado='1' WHERE id='$id'");

            // Guardar acción en Logs si se ha iniciado sesión
            $fecha_log = date("Y-m-d h:i:s", time());
            $username = $_SESSION['username'];
            $ip = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $pais = $_SERVER["HTTP_CF_IPCOUNTRY"];
            $accion = "Atendio la denuncia con la ID <b>$id</b>";
            $enviar_log = "INSERT INTO logs_moderacion (ip_mod,pais,usuario,accion,fecha) values ('" . $ip . "','" . $pais . "','" . $username . "','" . $accion . "','" . $fecha_log . "')";
            $conn->query($enviar_log);
            // Log guardado en Base de datos
            
        }
    }
}
?>
<script>location.href="../reportes.php";</script>
