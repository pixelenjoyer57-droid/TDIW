<?php
// model/carrito_m.php
require_once __DIR__ . '/connectaDb_m.php';

function agregarProductoCarrito($usuario_id, $producto_id, $cantidad) {
    global $conn;

    // 1. Buscar si el usuario ya tiene un carrito activo (podríamos añadir estado 'activo' en el futuro)
    // Por simplicidad, asumimos un único carrito por usuario o creamos uno si no existe.
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);

    if (!$carrito) {
        // Crear carrito
        $sqlInsert = "INSERT INTO carrito (id_usuario) VALUES ($1) RETURNING id";
        $resInsert = pg_query_params($conn, $sqlInsert, [$usuario_id]);
        $carrito = pg_fetch_assoc($resInsert);
    }
    
    $carrito_id = $carrito['id'];

    // 2. Verificar si el producto ya está en el carrito para sumar cantidad o insertar nuevo
    $sqlItem = "SELECT id, cantidad FROM item_carrito WHERE id_carrito = $1 AND id_producto = $2";
    $resItem = pg_query_params($conn, $sqlItem, [$carrito_id, $producto_id]);
    $item = pg_fetch_assoc($resItem);

    if ($item) {
        // Actualizar cantidad
        $nueva_cantidad = $item['cantidad'] + $cantidad;
        $sqlUpdate = "UPDATE item_carrito SET cantidad = $1 WHERE id = $2";
        pg_query_params($conn, $sqlUpdate, [$nueva_cantidad, $item['id']]);
    } else {
        // Insertar nuevo item
        $sqlInsertItem = "INSERT INTO item_carrito (id_carrito, id_producto, cantidad) VALUES ($1, $2, $3)";
        pg_query_params($conn, $sqlInsertItem, [$carrito_id, $producto_id, $cantidad]);
    }
    
    return true;
}

/**
 * Obtiene los productos del carrito de un usuario
 */
function getCarritoItems($usuario_id) {
    global $conn;
    
    // Primero obtenemos el ID del carrito activo
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);
    
    if (!$carrito) return [];
    
    // Obtenemos los productos con sus datos (JOIN)
    $sqlItems = "SELECT i.id as item_id, i.cantidad, p.nombre, p.precio, p.url_imagen, (p.precio * i.cantidad) as subtotal
                 FROM item_carrito i
                 JOIN producto p ON i.id_producto = p.id
                 WHERE i.id_carrito = $1
                 ORDER BY p.nombre ASC";
                 
    $resItems = pg_query_params($conn, $sqlItems, [$carrito['id']]);
    return pg_fetch_all($resItems) ?: [];
}

/**
 * Vacía el carrito (Simula la compra)
 */
function vaciarCarrito($usuario_id) {
    global $conn;
    
    // Obtener carrito
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);
    
    if ($carrito) {
        // Borrar items
        $sqlDelete = "DELETE FROM item_carrito WHERE id_carrito = $1";
        pg_query_params($conn, $sqlDelete, [$carrito['id']]);
        return true;
    }
    return false;
}

/**
 * Elimina un item específico (Opcional para mejorar UX)
 */
function eliminarItemCarrito($item_id) {
    global $conn;
    $sql = "DELETE FROM item_carrito WHERE id = $1";
    return pg_query_params($conn, $sql, [$item_id]);
}
?>