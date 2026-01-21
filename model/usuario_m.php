<?php
// model/usuario_m.php
// Modelo para gestionar usuarios

require_once __DIR__ . '/connectaDb_m.php';

/**
 * Registra un nuevo usuario en la base de datos
 * @param array $datos - Array con datos del usuario
 * @return bool - true si se registró exitosamente
 */
function registrarUsuario($datos) {
    global $conn;
    
    // Validar que la conexión existe
    if (!$conn) {
        throw new Exception("Error de conexión a la base de datos");
    }
    
    // Cifrar la contraseña con bcrypt (MUY SEGURO)
    $password_hash = password_hash($datos['contrasena'], PASSWORD_BCRYPT, ['cost' => 12]);
    
    // Consulta parametrizada (protege contra SQL Injection)
    $sql = "INSERT INTO usuario 
            (nombre_usuario, email, nombre, apellido, contrasena, numero_telefono) 
            VALUES ($1, $2, $3, $4, $5, $6)
            RETURNING id";
    
    $params = [
        $datos['nombre_usuario'],
        $datos['email'],
        $datos['nombre'],
        $datos['apellido'],
        $password_hash,
        $datos['numero_telefono'] ?? NULL
    ];
    
    try {
        $result = pg_query_params($conn, $sql, $params);
        
        if (!$result) {
            $error = pg_last_error($conn);
            // Detectar si es error de duplicación de email o usuario
            if (strpos($error, 'unique') !== false || strpos($error, 'duplicate') !== false) {
                throw new Exception("El email o nombre de usuario ya existen");
            }
            throw new Exception("Error al registrar: " . $error);
        }
        
        return true;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}

/**
 * Obtiene un usuario por email
 * @param string $email
 * @return array|false
 */
function getUsuarioByEmail($email) {
    global $conn;
    
    $sql = "SELECT id, nombre_usuario, email, nombre, apellido, contrasena, numero_telefono
            FROM usuario 
            WHERE email = $1";
    
    $result = pg_query_params($conn, $sql, [$email]);
    
    if (!$result) {
        return false;
    }
    
    return pg_fetch_assoc($result);
}

/**
 * Verifica las credenciales de login
 * @param string $email
 * @param string $password
 * @return array|false - Datos del usuario si login correcto, false si no
 */
function verificarLogin($email, $password) {
    $usuario = getUsuarioByEmail($email);
    
    if (!$usuario) {
        return false;
    }
    
    // Verificar contraseña cifrada con bcrypt
    if (password_verify($password, $usuario['contrasena'])) {
        // No devolvemos la contraseña por seguridad
        unset($usuario['contrasena']);
        return $usuario;
    }
    
    return false;
}

/**
 * Obtiene un usuario por ID
 * @param int $id
 * @return array|false
 */
function getUsuarioById($id) {
    global $conn;
    
    // CORRECCIÓN: Añadido 'imagen_perfil' a la lista de campos
    $sql = "SELECT id, nombre_usuario, email, nombre, apellido, numero_telefono, fecha_registro, imagen_perfil
            FROM usuario 
            WHERE id = $1";
    
    $result = pg_query_params($conn, $sql, [$id]);
    
    if (!$result) {
        return false;
    }
    
    return pg_fetch_assoc($result);
}

function actualizarTelefonoUsuario($usuario_id, $telefono) {
    global $conn;
    $sql = "UPDATE usuario SET numero_telefono = $1 WHERE id = $2";
    $params = [$telefono, $usuario_id];
    $res = pg_query_params($conn, $sql, $params);
    if (!$res) throw new Exception("Error al actualizar");
}

function eliminarUsuario($usuario_id) {
    global $conn;
    $sql = "DELETE FROM usuario WHERE id = $1";
    $params = [$usuario_id];
    $res = pg_query_params($conn, $sql, $params);
    if (!$res) throw new Exception("Error al eliminar");
}

function actualizarImagenUsuario($id, $ruta) {
    global $conn;
    $sql = "UPDATE usuario SET imagen_perfil = $1 WHERE id = $2";
    pg_query_params($conn, $sql, [$ruta, $id]);
}

?>

