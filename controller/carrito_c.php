<?php
// controller/carrito_c.php
require_once __DIR__ . '/../model/carrito_m.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar si está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?accio=login');
    exit;
}

// Obtener items
$items = getCarritoItems($_SESSION['usuario_id']);

// Calcular total
$total = 0;
foreach ($items as $item) {
    $total += $item['subtotal'];
}

// Cargar vista
require __DIR__ . '/../view/carrito_v.php';
?>