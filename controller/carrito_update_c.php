<?php
// controller/carrito_update_c.php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Sesión expirada']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$producto_id = $input['producto_id'] ?? null;
$accion = $input['accion'] ?? null; // 'sumar', 'restar', 'eliminar'

if (!$producto_id || !$accion) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

if (!isset($_SESSION['carrito'][$producto_id])) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado en el carrito']);
    exit;
}

// Lógica de actualización
if ($accion === 'eliminar') {
    unset($_SESSION['carrito'][$producto_id]);
} elseif ($accion === 'sumar') {
    $_SESSION['carrito'][$producto_id]['cantidad']++;
} elseif ($accion === 'restar') {
    if ($_SESSION['carrito'][$producto_id]['cantidad'] > 1) {
        $_SESSION['carrito'][$producto_id]['cantidad']--;
    } else {
        // Si es 1 y restamos, lo eliminamos (opcional, o mostrar aviso)
        unset($_SESSION['carrito'][$producto_id]);
    }
}

// Recalcular totales para devolver al frontend
$nuevoTotal = 0;
$totalItems = 0;
foreach ($_SESSION['carrito'] as $item) {
    $nuevoTotal += $item['precio'] * $item['cantidad'];
    $totalItems += $item['cantidad'];
}

echo json_encode([
    'success' => true, 
    'nuevo_total_global' => number_format($nuevoTotal, 2),
    'items_count' => $totalItems
]);
?>