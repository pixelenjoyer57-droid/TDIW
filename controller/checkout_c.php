<?php
// controller/checkout_c.php
require_once __DIR__ . '/../model/carrito_m.php';
require_once __DIR__ . '/../model/connectaDb_m.php'; // Necesitamos conexión directa

if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?accio=login');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$items = getCarritoItems($usuario_id);

if (empty($items)) {
    // No se puede comprar un carrito vacío
    header('Location: index.php?accio=carrito');
    exit;
}

// 1. Calcular total
$total = 0;
foreach ($items as $item) {
    $total += $item['subtotal'];
}

// 2. Insertar Pedido (Cabecera)
global $conn; // Aseguramos tener conexión
$sqlPedido = "INSERT INTO pedido (id_usuario, importe_total) VALUES ($1, $2) RETURNING id";
$resPedido = pg_query_params($conn, $sqlPedido, [$usuario_id, $total]);
$pedidoRow = pg_fetch_assoc($resPedido);
$pedido_id = $pedidoRow['id'];

// 3. Insertar Líneas de Pedido (Detalle)
$sqlLinea = "INSERT INTO linea_pedido (id_pedido, id_producto, cantidad, precio_unitario) VALUES ($1, $2, $3, $4)";
foreach ($items as $item) {
// En controller/checkout_c.php dentro del foreach:
    pg_query_params($conn, $sqlLinea, [
        $pedido_id, 
        $item['id_producto'], // <--- Ahora esto funcionará correctamente
        $item['cantidad'], 
        $item['precio']
    ]);
}

// 4. Vaciar Carrito (Ahora sí es seguro borrar)
vaciarCarrito($usuario_id);

$compra_realizada = true;
$items = []; // Para que la vista muestre carrito vacío
$total = 0;

// Reutilizamos la vista del carrito para mostrar mensaje de éxito
require __DIR__ . '/../view/carrito_v.php';
?>