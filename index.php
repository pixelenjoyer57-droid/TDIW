<?php
// index.php - Router (Enrutador)

// Recogemos la acción desde la URL
$accio = $_GET['accio'] ?? NULL;

// Enrutamos según la acción
switch ($accio) {
    case 'llistar-categories':
        include __DIR__ . '/resource/llistar_categories.php';
        break;
    
    case 'llistar-productes':
        include __DIR__ . '/resource/llistar_productes.php';
        break;
    
    case 'detall-producte':
        include __DIR__ . '/resource/detall_producte.php';
        break;
    
    case 'registre':
        include __DIR__ . '/resource/registre.php';
        break;
    
    case 'login':
        include __DIR__ . '/resource/login.php';
        break;
    
    case 'logout':
        include __DIR__ . '/controller/logout_c.php';
        break;

    case 'perfil':
        include __DIR__ . '/controller/perfil_c.php';
        break;
    
    case 'carrito':
        include __DIR__ . '/resource/carrito.php'; // Crearemos este recurso abajo
        break;
        
    case 'checkout':
        include __DIR__ . '/controller/checkout_c.php';
        break;
    
    case 'mis-pedidos':
        include __DIR__ . '/controller/mis_pedidos_c.php'; // Tendrás que crear este controlador simple
        break;
    
    default:
        include __DIR__ . '/resource/portada.php';
        break;
}
?>
