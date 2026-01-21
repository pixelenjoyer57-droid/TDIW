<?php
// controller/perfil_c.php
require_once __DIR__ . '/../model/usuario_m.php';

if (session_status() === PHP_SESSION_NONE) session_start();

// Verificar autenticación
if(!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?accio=login');
    exit();
}

// Obtener datos frescos del usuario desde la BD
$usuario = getUsuarioById($_SESSION['usuario_id']);

if (!$usuario) {
    // Si el usuario no existe en BD pero sí en sesión (caso raro), limpiar
    session_destroy();
    header('Location: index.php');
    exit();
}

// Incluir la vista pasando los datos en $usuario
require __DIR__ . '/../view/perfil_v.php';
?>