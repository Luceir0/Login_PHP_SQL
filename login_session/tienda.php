<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: http://localhost/DUWES/login_session/login.php");
}

echo "Has entrado en la tienda. Hola, " . $_SESSION["login"];
?>
