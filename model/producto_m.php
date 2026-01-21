<?php
// model/producto_m.php
// Modelo para gestionar productos

require_once __DIR__ . '/connectaDb_m.php';

/**
 * Obtiene productos de una categoría
 * @param int $id_categoria
 * @return array
 */
function getProductosByCategoria($id_categoria) {
    global $conn;
    
    // Consulta parametrizada
    $sql = "SELECT id, nombre, descripcion, precio, stock, url_imagen, id_categoria
            FROM producto 
            WHERE id_categoria = $1 
            ORDER BY nombre ASC";
    
    $result = pg_query_params($conn, $sql, [$id_categoria]);
    
    if (!$result) {
        die("Error en consulta: " . pg_last_error($conn));
    }
    
    $productos = pg_fetch_all($result);
    return $productos ?: [];
}

/**
 * Obtiene detalle de un producto por ID
 * @param int $id
 * @return array|false
 */
function getProductoById($id) {
    global $conn;
    
    $sql = "SELECT p.id, p.nombre, p.descripcion, p.precio, p.stock, 
                   p.url_imagen, p.id_categoria, c.nombre as categoria_nombre
            FROM producto p
            INNER JOIN categoria c ON p.id_categoria = c.id
            WHERE p.id = $1";
    
    $result = pg_query_params($conn, $sql, [$id]);
    
    if (!$result) {
        die("Error en consulta: " . pg_last_error($conn));
    }
    
    return pg_fetch_assoc($result);
}

/**
 * Obtiene todos los productos
 * @return array
 */
function getAllProductos() {
    global $conn;
    
    $sql = "SELECT id, nombre, descripcion, precio, stock, url_imagen, id_categoria
            FROM producto 
            ORDER BY nombre ASC";
    
    $result = pg_query($conn, $sql);
    
    if (!$result) {
        die("Error en consulta: " . pg_last_error($conn));
    }
    
    $productos = pg_fetch_all($result);
    return $productos ?: [];
}
?>
