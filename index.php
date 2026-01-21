<?php
// index.php - Router SPA
session_start();

// Detectamos si es una petición AJAX (SPA)
$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

$accio = $_GET['accio'] ?? NULL;

// 1. Si NO es Ajax, cargamos la cabecera común (<html>, <head>, menú...)
if (!$is_ajax) {
    include __DIR__ . '/resource/header_common.php';
    echo '<main class="container">'; // Abrimos el contenedor principal
}

// 2. Enrutador: Carga CONTROLLERS directamente, no resources "envoltorio"
switch ($accio) {
    case 'llistar-categories':
        // CAMBIO: Apuntamos al controller, no al resource/llistar_categories.php antiguo
        include __DIR__ . '/controller/llistar_categories_c.php'; 
        break;
    
    case 'llistar-productes':
        include __DIR__ . '/controller/llistar_productes_c.php';
        break;
    
    case 'detall-producte':
        include __DIR__ . '/controller/detall_producte_c.php';
        break;
    
    case 'registre':
        include __DIR__ . '/controller/registre_c.php';
        break;
    
    case 'login':
        include __DIR__ . '/controller/login_c.php';
        break;
    
    case 'logout':
        include __DIR__ . '/controller/logout_c.php';
        break;

    case 'perfil':
        include __DIR__ . '/controller/perfil_c.php';
        break;
    
    case 'carrito':
        include __DIR__ . '/controller/carrito_c.php';
        break;
        
    case 'checkout':
        include __DIR__ . '/controller/checkout_c.php';
        break;
    
    case 'mis-pedidos':
        include __DIR__ . '/controller/mis_pedidos_c.php';
        break;
    
    default:
        // Para la portada, si no tienes controller, carga la vista directa (sin <html> extra)
        include __DIR__ . '/resource/portada.php'; 
        break;
}

// 3. Si NO es Ajax, cerramos el main y cargamos el footer
if (!$is_ajax) {
    echo '</main>';
    include __DIR__ . '/resource/footer_common.php';
}
?>