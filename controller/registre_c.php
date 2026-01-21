<?php
// controller/registre_c.php
// Controlador para el registro de usuarios

require_once __DIR__ . '/../model/usuario_m.php';

$mensaje = '';
$error = '';
$form_data = [];

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Recopilar datos
    $form_data = [
        'nombre_usuario' => $_POST['nombre_usuario'] ?? '',
        'email' => $_POST['email'] ?? '',
        'nombre' => $_POST['nombre'] ?? '',
        'apellido' => $_POST['apellido'] ?? '',
        'numero_telefono' => $_POST['numero_telefono'] ?? '',
        'contrasena' => $_POST['contrasena'] ?? '',
        'contrasena_confirmar' => $_POST['contrasena_confirmar'] ?? '',
    ];
    
    // ====== VALIDACIONES SERVIDOR ======
    
    // 1. Validar campos obligatorios
    if (empty($form_data['nombre_usuario']) || empty($form_data['email']) || 
        empty($form_data['contrasena']) || empty($form_data['nombre']) || 
        empty($form_data['apellido'])) {
        $error = "❌ Todos los campos obligatorios (*) deben estar completos.";
    }
    
    // 2. Validar longitud del nombre de usuario (3-50 caracteres)
    elseif (strlen($form_data['nombre_usuario']) < 3 || strlen($form_data['nombre_usuario']) > 50) {
        $error = "❌ El nombre de usuario debe tener entre 3 y 50 caracteres.";
    }
    
    // 3. Validar formato de email
    elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
        $error = "❌ El email no es válido.";
    }
    
    // 4. Validar que las contraseñas coincidan
    elseif ($form_data['contrasena'] !== $form_data['contrasena_confirmar']) {
        $error = "❌ Las contraseñas no coinciden.";
    }
    
    // 5. Validar longitud de contraseña (mínimo 6 caracteres)
    elseif (strlen($form_data['contrasena']) < 6) {
        $error = "❌ La contraseña debe tener al menos 6 caracteres.";
    }
    
    // 6. Validar que no contenga caracteres especiales peligrosos
    elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $form_data['nombre_usuario'])) {
        $error = "❌ El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.";
    }
    
    // 7. Validar nombres (solo letras y espacios)
    elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $form_data['nombre'])) {
        $error = "❌ El nombre solo puede contener letras.";
    }
    
    elseif (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/', $form_data['apellido'])) {
        $error = "❌ El apellido solo puede contener letras.";
    }
    
    // 8. Validar teléfono si se proporciona (formato: +34 666 777 888)
    elseif (!empty($form_data['numero_telefono']) && 
            !preg_match('/^[\d\s\+\-\(\)]+$/', $form_data['numero_telefono'])) {
        $error = "❌ El formato del teléfono no es válido.";
    }
    
    // Si todas las validaciones pasaron
    else {
        try {
            // Verificar si el usuario ya existe
            $usuarioExistente = getUsuarioByEmail($form_data['email']);
            
            if ($usuarioExistente) {
                $error = "❌ Este email ya está registrado. Intenta con otro o inicia sesión.";
            } else {
                // Registrar el usuario
                if (registrarUsuario($form_data)) {
                    $mensaje = "✅ ¡Usuario registrado exitosamente! Ahora puedes iniciar sesión.";
                    $form_data = []; // Limpiar formulario
                }
            }
        } catch (Exception $e) {
            $error = "❌ Error al registrar usuario. Por favor, intenta más tarde.";
            error_log("Error de registro: " . $e->getMessage());
        }
    }
}

// Incluir la vista
include __DIR__ . '/../view/registre_v.php';
?>
