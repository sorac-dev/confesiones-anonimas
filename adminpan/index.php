<?php
require('core/server.php');
?>
<?php
if (isset($_SESSION['logeado']) != "SI") {
    header("Location: login");
} else {
    header("Location: dashboard");
}
?>