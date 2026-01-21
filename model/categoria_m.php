<?php
// model/categoria_m.php
// Modelo para gestionar categorías

require_once __DIR__ . '/connectaDb_m.php';

/**
 * Obtiene todas las categorías
 * @return array - Array de categorías
 */
function getCategorias() {
    global $conn;
    
    $sql = "SELECT id, nombre, descripcion 
            FROM categoria 
            ORDER BY nombre ASC";
    
    $result = pg_query($conn, $sql);
    
    if (!$result) {
        die("Error en consulta: " . pg_last_error($conn));
    }
    
    $categorias = pg_fetch_all($result);
    return $categorias ?: [];
}

/**
 * Obtiene una categoría por ID
 * @param int $id - ID de la categoría
 * @return array|false
 */
function getCategoriaById($id) {
    global $conn;
    
    // Consulta parametrizada (evita SQL Injection)
    $sql = "SELECT id, nombre, descripcion 
            FROM categoria 
            WHERE id = $1";
    
    $result = pg_query_params($conn, $sql, [$id]);
    
    if (!$result) {
        die("Error en consulta: " . pg_last_error($conn));
    }
    
    return pg_fetch_assoc($result);
}
?>
