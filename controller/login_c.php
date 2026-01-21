<?php
// controller/login_c.php
require_once __DIR__ . '/../model/usuario_m.php';

$is_ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
$mensaje = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (empty($_POST['email']) || empty($_POST['contrasena'])) {
        $error = "Email y contraseña son obligatorios.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['contrasena'];
        
        $usuario = verificarLogin($email, $password);
        
        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['email'] = $usuario['email'];
            
            // SI ES AJAX: Devolver JSON para forzar recarga
            if ($is_ajax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'redirect' => 'index.php']);
                exit;
            }

            // SI NO ES AJAX: Redirección normal
            $mensaje = "Inicio de sesión exitoso. Redirigiendo...";
            header("Refresh: 2; url=index.php");
        } else {
            $error = "Email o contraseña incorrectos.";
            // Si es ajax y hay error, devolvemos el error en JSON o HTML parcial
            if ($is_ajax) {
                // Opción simple: Devolvemos el HTML del formulario con el error
                // Para que el JS lo pinte dentro del main
            }
        }
    }
}

// Incluir la vista (esto devolverá el HTML del formulario si hubo error o si es GET)
include __DIR__ . '/../view/login_v.php';
?>