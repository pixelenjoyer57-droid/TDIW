<?php
// controller/menu_superior_c.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../model/carrito_m.php';

$usuario_logueado = isset($_SESSION['usuario_id']);
$nombre_usuario = $_SESSION['nombre_usuario'] ?? '';

// === CÁLCULO DEL CARRITO DESDE BD ===
$carrito_total_items = 0;
$carrito_total_precio = 0.00;
$items_menu = []; // Variable para el desplegable (stash)

if ($usuario_logueado) {
    // Obtenemos los items REALES de la base de datos
    $items_menu = getCarritoItems($_SESSION['usuario_id']);
    
    foreach ($items_menu as $item) {
        $carrito_total_items += $item['cantidad'];
        $carrito_total_precio += $item['subtotal'];
    }
}
// ====================================

include __DIR__ . '/../view/menu_superior_v.php';
?>