<?php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');
if(!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "error" => "No autenticado"]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);
$telefono = $data['telefono'] ?? '';
if (!preg_match('/^[0-9]{9,15}$/', $telefono)) {
    echo json_encode(["success" => false, "error" => "Teléfono no válido"]);
    exit;
}
require_once __DIR__ . '/../model/usuario_m.php';
try {
    actualizarTelefonoUsuario($_SESSION['usuario_id'], $telefono);
    $_SESSION['usuario_telefono'] = $telefono;
    echo json_encode(["success" => true]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => "Error de BD"]);
}
