<?php
// controller/login_c.php
// Controlador para el inicio de sesión

require_once __DIR__ . '/../model/usuario_m.php';


$mensaje = '';
$error = '';

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validación básica
    if (empty($_POST['email']) || empty($_POST['contrasena'])) {
        $error = "Email y contraseña son obligatorios.";
    } else {
        $email = $_POST['email'];
        $password = $_POST['contrasena'];
        
        // Verificar credenciales
        $usuario = verificarLogin($email, $password);
        
        if ($usuario) {
            // Login exitoso - guardar en sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['email'] = $usuario['email'];
            
            $mensaje = "Inicio de sesión exitoso. Redirigiendo...";
            header("Refresh: 2; url=index.php");
        } else {
            $error = "Email o contraseña incorrectos.";
        }
    }
}

// Incluir la vista
include __DIR__ . '/../view/login_v.php';
?>
