<?php
// controller/perfil_update_c.php
if (session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json');

if(!isset($_SESSION['usuario_id'])) {
    echo json_encode(["success" => false, "error" => "No autenticado"]);
    exit;
}

require_once __DIR__ . '/../model/usuario_m.php';

$response = ["success" => false];

try {
    // 1. Actualizar Teléfono
    if (isset($_POST['telefono'])) {
        $telefono = $_POST['telefono'];
        // Validación básica
        if (preg_match('/^[0-9]{9,15}$/', $telefono)) {
             actualizarTelefonoUsuario($_SESSION['usuario_id'], $telefono);
             $response["success"] = true;
        }
    }

    // 2. Actualizar Imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../resource/img/usuarios/';
        if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($ext), ['jpg','jpeg','png','gif'])) {
            throw new Exception("Formato no válido");
        }

        // Nombre único para evitar caché y colisiones
        $newFileName = 'user_' . $_SESSION['usuario_id'] . '.' . $ext;
        $destPath = $uploadDir . $newFileName;
        
        if(move_uploaded_file($_FILES['imagen']['tmp_name'], $destPath)) {
            // Guardar ruta relativa en BD (importante para HTML)
            $webPath = 'resource/img/usuarios/' . $newFileName;
            
            // Necesitas crear esta función en usuario_m.php
            actualizarImagenUsuario($_SESSION['usuario_id'], $webPath);
            
            $response["success"] = true;
            $response["new_image"] = $webPath;
        }
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>  