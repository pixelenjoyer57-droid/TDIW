<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
if(!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "error" => "No autenticado"]);
    exit;
}
require_once __DIR__ . '/../model/usuario_m.php';
try {
    eliminarUsuario($_SESSION['usuario_id']);
    session_destroy();
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => "No se pudo eliminar"]);
}
