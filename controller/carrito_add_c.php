<?php
// controller/carrito_add_c.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../model/carrito_m.php';

// Verificar login
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Debes iniciar sesión']);
    exit;
}

// Leer JSON del body
$input = json_decode(file_get_contents('php://input'), true);
$producto_id = $input['producto_id'] ?? null;
$cantidad = $input['cantidad'] ?? 1;

if (!$producto_id) {
    echo json_encode(['success' => false, 'error' => 'Producto no válido']);
    exit;
}

try {
    agregarProductoCarrito($_SESSION['usuario_id'], $producto_id, $cantidad);
    echo json_encode(['success' => true, 'message' => 'Producto añadido']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Error en BD']);
}
?>