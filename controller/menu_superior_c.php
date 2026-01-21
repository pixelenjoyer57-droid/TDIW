<?php
// controller/menu_superior_c.php
// Controlador para el menú superior de navegación

session_start();

// Verificar si el usuario está autenticado
$usuario_logueado = isset($_SESSION['usuario_id']) ? true : false;
$nombre_usuario = $_SESSION['nombre_usuario'] ?? '';

// Incluir la vista
include __DIR__ . '/../view/menu_superior_v.php';
?>
