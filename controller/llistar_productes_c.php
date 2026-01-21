<?php
// controller/llistar_productes_c.php
// Controlador para listar productos de una categoría

require_once __DIR__ . '/../model/producto_m.php';
require_once __DIR__ . '/../model/categoria_m.php';

// Obtenemos el ID de la categoría desde la URL
$categoria_id = $_GET['categoria'] ?? NULL;

if (!$categoria_id) {
    // Si no viene categoría, redirigir a inicio
    header("Location: index.php");
    exit;
}

// Obtenemos los datos
$productos = getProductosByCategoria($categoria_id);
$categoria = getCategoriaById($categoria_id);

if (!$categoria) {
    die("❌ Error: La categoría no existe.");
}

// Incluimos la vista
include __DIR__ . '/../view/llistar_productes_v.php';
?>
