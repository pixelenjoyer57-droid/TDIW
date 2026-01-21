<?php
// controller/checkout_c.php
require_once __DIR__ . '/../model/carrito_m.php';

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?accio=login');
    exit;
}

// Vaciar el carrito
vaciarCarrito($_SESSION['usuario_id']);

// Mostrar mensaje de éxito (podríamos crear una vista específica, 
// pero por simplicidad reutilizaremos un mensaje en la vista del carrito vacío o redirigimos)
$mensaje_exito = "¡Pedido realizado con éxito! Gracias por tu compra.";
$compra_realizada = true;

// Reutilizamos la vista del carrito pero vacía y con mensaje
$items = [];
$total = 0;
require __DIR__ . '/../view/carrito_v.php';
?>