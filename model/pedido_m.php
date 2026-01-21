<?php
// model/pedido_m.php
require_once __DIR__ . '/connectaDb_m.php';

function getPedidosUsuario($usuario_id) {
    global $conn;
    $sql = "SELECT id, fecha_creacion, importe_total 
            FROM pedido 
            WHERE id_usuario = $1 
            ORDER BY fecha_creacion DESC";
    
    $res = pg_query_params($conn, $sql, [$usuario_id]);
    return pg_fetch_all($res) ?: [];
}
?>