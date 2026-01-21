<?php
// controller/menu_superior_c.php
// Controlador para el menú superior de navegación

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
$usuario_logueado = isset($_SESSION['usuario_id']);
$nombre_usuario = $_SESSION['nombre_usuario'] ?? '';

// === CÁLCULO DEL CARRITO PARA EL MENÚ ===
$carrito_total_items = 0;
$carrito_total_precio = 0.00;

if (isset($_SESSION['carrito']) && is_array($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cant = (int)$item['cantidad'];
        $precio = (float)$item['precio'];
        
        $carrito_total_items += $cant;
        $carrito_total_precio += ($precio * $cant);
    }
}
// ========================================

// Incluir la vista
include __DIR__ . '/../view/menu_superior_v.php';
?>