<?php
// controller/logout_c.php
// Controlador para cerrar sesión

session_start();

// Destruir la sesión
session_destroy();

// Redirigir a la portada
header("Location: index.php");
exit();
?>
