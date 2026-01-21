<?php

// 1. Destruir la sesión
session_destroy();

// 2. Detectar si es AJAX (SPA)
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

if ($is_ajax) {
    // Si es SPA, devolvemos JSON para que JS recargue la página
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'redirect' => 'index.php']);
    exit();
}

// 3. Si NO es AJAX (navegación normal), redirigimos
header("Location: index.php");
exit();
?>