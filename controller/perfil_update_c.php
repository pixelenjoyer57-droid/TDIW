<?php
// controller/perfil_update_c.php
// Limpiamos cualquier salida previa (warnings, espacios en blanco)
ob_start();

session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../model/usuario_m.php';

$response = ['success' => false, 'error' => 'Error desconocido'];

try {
    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception('No estás autenticado');
    }

    $usuario_id = $_SESSION['usuario_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Actualizar teléfono
        if (isset($_POST['telefono'])) {
            $telefono = trim($_POST['telefono']);
            actualizarTelefonoUsuario($usuario_id, $telefono);
        }

        // 2. Subida de imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['imagen'];
            
            // Validaciones
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($file['type'], $allowedTypes)) {
                throw new Exception("Formato no válido. Usa JPG, PNG o GIF.");
            }

            // Definir ruta absoluta
            $uploadDir = __DIR__ . '/../resource/img/usuarios/';
            
            // Intentar crear carpeta si no existe
            if (!is_dir($uploadDir)) {
                if (!mkdir($uploadDir, 0777, true)) {
                    throw new Exception("No se pudo crear el directorio de imágenes.");
                }
            }

            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'user_' . $usuario_id . '_' . time() . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Ruta relativa para la BD (sin ../)
                $dbPath = 'resource/img/usuarios/' . $fileName;
                actualizarImagenUsuario($usuario_id, $dbPath);
            } else {
                throw new Exception("Falló al mover el archivo. Revisa permisos de carpeta.");
            }
        }
        
        $response = ['success' => true, 'message' => 'Perfil actualizado'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'error' => $e->getMessage()];
}

// Limpiar buffer y enviar JSON puro
ob_end_clean();
echo json_encode($response);
?>