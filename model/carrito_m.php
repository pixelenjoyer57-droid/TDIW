<?php
// model/carrito_m.php
require_once __DIR__ . '/connectaDb_m.php';

function agregarProductoCarrito($usuario_id, $producto_id, $cantidad) {
    global $conn;

    // Buscar carrito activo
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);

    if (!$carrito) {
        $sqlInsert = "INSERT INTO carrito (id_usuario) VALUES ($1) RETURNING id";
        $resInsert = pg_query_params($conn, $sqlInsert, [$usuario_id]);
        $carrito = pg_fetch_assoc($resInsert);
    }
    
    $carrito_id = $carrito['id'];

    // Verificar si existe el item
    $sqlItem = "SELECT id, cantidad FROM item_carrito WHERE id_carrito = $1 AND id_producto = $2";
    $resItem = pg_query_params($conn, $sqlItem, [$carrito_id, $producto_id]);
    $item = pg_fetch_assoc($resItem);

    if ($item) {
        $nueva_cantidad = $item['cantidad'] + $cantidad;
        $sqlUpdate = "UPDATE item_carrito SET cantidad = $1 WHERE id = $2";
        pg_query_params($conn, $sqlUpdate, [$nueva_cantidad, $item['id']]);
    } else {
        $sqlInsertItem = "INSERT INTO item_carrito (id_carrito, id_producto, cantidad) VALUES ($1, $2, $3)";
        pg_query_params($conn, $sqlInsertItem, [$carrito_id, $producto_id, $cantidad]);
    }
    return true;
}

function getCarritoItems($usuario_id) {
    global $conn;
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);
    
    if (!$carrito) return [];
    
    $sqlItems = "SELECT i.id as item_id, p.id as id_producto, i.cantidad, p.nombre, p.precio, p.url_imagen, (p.precio * i.cantidad) as subtotal
                 FROM item_carrito i
                 JOIN producto p ON i.id_producto = p.id
                 WHERE i.id_carrito = $1
                 ORDER BY p.nombre ASC";
                 
    $resItems = pg_query_params($conn, $sqlItems, [$carrito['id']]);
    return pg_fetch_all($resItems) ?: [];
}

// === NUEVAS FUNCIONES NECESARIAS PARA ACTUALIZAR ===

function actualizarCantidadProducto($usuario_id, $producto_id, $nueva_cantidad) {
    global $conn;
    // 1. Obtener carrito
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $cart = pg_fetch_assoc($res);
    if (!$cart) return false;

    // 2. Actualizar directo en BD
    $sqlUpd = "UPDATE item_carrito SET cantidad = $1 WHERE id_carrito = $2 AND id_producto = $3";
    return pg_query_params($conn, $sqlUpd, [$nueva_cantidad, $cart['id'], $producto_id]);
}

function eliminarProductoUsuario($usuario_id, $producto_id) {
    global $conn;
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $cart = pg_fetch_assoc($res);
    if (!$cart) return false;

    $sqlDel = "DELETE FROM item_carrito WHERE id_carrito = $1 AND id_producto = $2";
    return pg_query_params($conn, $sqlDel, [$cart['id'], $producto_id]);
}

function vaciarCarrito($usuario_id) {
    global $conn;
    $sql = "SELECT id FROM carrito WHERE id_usuario = $1 ORDER BY fecha_creacion DESC LIMIT 1";
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    $carrito = pg_fetch_assoc($res);
    if ($carrito) {
        $sqlDelete = "DELETE FROM item_carrito WHERE id_carrito = $1";
        pg_query_params($conn, $sqlDelete, [$carrito['id']]);
        return true;
    }
    return false;
}
?>