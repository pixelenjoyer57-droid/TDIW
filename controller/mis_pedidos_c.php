<?php
// controller/mis_pedidos_c.php
require_once __DIR__ . '/../model/pedido_m.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?accio=login');
    exit;
}

// Obtener pedidos del usuario logueado
$pedidos = getPedidosUsuario($_SESSION['usuario_id']);

// Cargar vista
require __DIR__ . '/../view/mis_pedidos_v.php';
?>