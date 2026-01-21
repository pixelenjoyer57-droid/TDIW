<?php
// controller/detall_producte_c.php
// Controlador para mostrar detalle de un producto

require_once __DIR__ . '/../model/producto_m.php';

// Obtenemos el ID del producto desde la URL
$producto_id = $_GET['id'] ?? NULL;

if (!$producto_id) {
    die("Error: No se especificó un producto.");
}

// Obtenemos los datos del producto
$producto = getProductoById($producto_id);

if (!$producto) {
    die("Error: El producto no existe.");
}

// Incluimos la vista
include __DIR__ . '/../view/detall_producte_v.php';
?>
