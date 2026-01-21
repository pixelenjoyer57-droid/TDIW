<?php
// controller/llistar_categories_c.php
// Controlador para listar categorías

// Incluimos el modelo
require_once __DIR__ . '/../model/categoria_m.php';

// Obtenemos los datos del modelo
$categorias = getCategorias();

// Incluimos la vista
include __DIR__ . '/../view/llistar_categories_v.php';
?>
