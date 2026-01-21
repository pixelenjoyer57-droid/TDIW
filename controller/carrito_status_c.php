<?php
// controller/carrito_status_c.php
require_once __DIR__ . '/../model/carrito_m.php';

if (session_status() === PHP_SESSION_NONE) session_start();

header('Content-Type: application/json');

$response = [
    'success' => true,
    'total_items' => 0,
    'total_precio' => 0.00
];

if (isset($_SESSION['usuario_id'])) {
    $items = getCarritoItems($_SESSION['usuario_id']);
    foreach ($items as $item) {
        $response['total_items'] += $item['cantidad'];
        $response['total_precio'] += $item['subtotal'];
    }
}

echo json_encode($response);
?>