<?php
// controller/carrito_update_c.php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../model/carrito_m.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'error' => 'Sesión expirada']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$producto_id = $input['producto_id'] ?? null;
$accion = $input['accion'] ?? null;
$usuario_id = $_SESSION['usuario_id'];

if (!$producto_id || !$accion) {
    echo json_encode(['success' => false, 'error' => 'Datos inválidos']);
    exit;
}

// 1. Obtener estado actual del carrito desde la BD
$items = getCarritoItems($usuario_id);
$item_actual = null;

foreach ($items as $item) {
    if ($item['id_producto'] == $producto_id) {
        $item_actual = $item;
        break;
    }
}

if (!$item_actual) {
    echo json_encode(['success' => false, 'error' => 'Producto no encontrado']);
    exit;
}

// 2. Calcular nueva cantidad
$nueva_cantidad = $item_actual['cantidad'];

if ($accion === 'sumar') {
    $nueva_cantidad++;
} elseif ($accion === 'restar') {
    $nueva_cantidad--;
} elseif ($accion === 'eliminar') {
    $nueva_cantidad = 0;
}

// 3. Aplicar cambios en BD
if ($nueva_cantidad <= 0) {
    eliminarProductoUsuario($usuario_id, $producto_id);
} else {
    actualizarCantidadProducto($usuario_id, $producto_id, $nueva_cantidad);
}

// 4. Recalcular totales para respuesta rápida (opcional, o recargar página)
// Para simplificar, devolvemos success y dejamos que el frontend recargue
echo json_encode(['success' => true]);
?>