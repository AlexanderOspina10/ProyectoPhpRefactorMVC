<?php
/**
 * Modelo Usuario
 * Maneja todas las operaciones relacionadas con usuarios
 */

class Usuario {
    private $conexion;
    private $tabla = 'usuarios';
    
    public $id;
    public $correo;
    public $nombre;
    public $apellido;
    public $telefono;
    public $direccion;
    public $rol_id;
    public $clave;
    public $activo;
    
    public function __construct() {
        global $con;
        $this->conexion = $con;
    }
    
    /**
     * Verificar si un correo ya existe
     */
    private function correoExiste($correo, $excluirId = null) {
        $query = "SELECT id FROM " . $this->tabla . " WHERE correo = ?";
        
        if ($excluirId) {
            $query .= " AND id != ?";
        }
        
        $stmt = $this->conexion->prepare($query);
        
        if ($excluirId) {
            $stmt->bind_param("si", $correo, $excluirId);
        } else {
            $stmt->bind_param("s", $correo);
        }
        
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->num_rows > 0;
    }
    
    /**
     * Crear un nuevo usuario
     */
    public function crear() {
        // Validaciones
        if ($this->correoExiste($this->correo)) {
            return [
                'success' => false,
                'message' => 'El correo electrónico ya está registrado'
            ];
        }
        if ($this->telefonoExiste($this->telefono)) {
            return [
                'success' => false,
                'message' => 'El teléfono ya está registrado'
            ];
        }
        if (strlen($this->clave) < 6) {
            return [
                'success' => false,
                'message' => 'La contraseña debe tener al menos 6 caracteres'
            ];
        }
                
        if (strlen($this->clave) < 6) {
            return [
                'success' => false,
                'message' => 'La contraseña debe tener al menos 6 caracteres'
            ];
        }
        
        // Hashear contraseña
        $claveHasheada = password_hash($this->clave, PASSWORD_BCRYPT);
        
        $query = "INSERT INTO " . $this->tabla . " 
                  (correo, nombre, apellido, telefono, direccion, rol_id, clave, activo) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
        
        $stmt = $this->conexion->prepare($query);
        
        if (!$stmt) {
            return [
                'success' => false,
                'message' => 'Error al preparar la consulta'
            ];
        }
        
        $stmt->bind_param(
            "sssssss",
            $this->correo,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->direccion,
            $this->rol_id,
            $claveHasheada
        );
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Usuario creado exitosamente',
                'usuario_id' => $this->conexion->insert_id
            ];
        } else {
            
            $errno = $this->conexion->errno;
            $errorMessage = $this->conexion->error;
            if ($errno == 1062) {
                return [
                    'success' => false,
                    'message' => 'Ya existe un usuario con ese correo o teléfono'
                ];
            }

            return [
                'success' => false,
                'message' => 'Error al crear el usuario: ' . $errorMessage
            ];
        }
    }
    
    /**
     * Login de usuario
     */
    public function login($correo, $clave) {
        $query = "SELECT u.id, u.nombre, u.correo, u.clave, u.activo, r.nombre as rol_nombre 
                  FROM " . $this->tabla . " u 
                  JOIN roles r ON u.rol_id = r.id 
                  WHERE u.correo = ? AND u.activo = 1";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 0) {
            return [
                'success' => false,
                'message' => 'Correo o contraseña incorrectos'
            ];
        }
        
        $usuario = $resultado->fetch_assoc();
        
        // Verificar contraseña
        if (!password_verify($clave, $usuario['clave'])) {
            return [
                'success' => false,
                'message' => 'Correo o contraseña incorrectos'
            ];
        }
        
        return [
            'success' => true,
            'message' => 'Login exitoso',
            'usuario' => $usuario
        ];
    }
    
            /**
         * Obtener todos los usuarios (con búsqueda opcional)
         * @param string|null $search Texto de búsqueda (aplica a correo, nombre, apellido, telefono)
                * @return array
                */
            public function obtenerTodos($search = null, $limit = 10, $offset = 0) {
            $baseQuery = "SELECT u.id, u.correo, u.nombre, u.apellido, u.telefono, u.direccion, 
                                u.activo, u.created_at, r.nombre as rol_nombre 
                        FROM " . $this->tabla . " u 
                        JOIN roles r ON u.rol_id = r.id ";

            if ($search && strlen(trim($search)) > 0) {
                $like = '%' . $search . '%';
                $query = $baseQuery . " WHERE (u.correo LIKE ? OR u.nombre LIKE ? OR u.apellido LIKE ? OR u.telefono LIKE ?) 
                                        ORDER BY u.created_at DESC 
                                        LIMIT ? OFFSET ?";
                $stmt = $this->conexion->prepare($query);
                $stmt->bind_param("ssssii", $like, $like, $like, $like, $limit, $offset);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } else {
                $query = $baseQuery . " ORDER BY u.created_at DESC LIMIT ? OFFSET ?";
                $stmt = $this->conexion->prepare($query);
                $stmt->bind_param("ii", $limit, $offset);
                $stmt->execute();
                $resultado = $stmt->get_result();
            }

            $usuarios = [];
            while ($fila = $resultado->fetch_assoc()) {
                $usuarios[] = $fila;
            }

            return $usuarios;
        }

        /**
         * Contar total de usuarios (para paginación)
         */
        public function contarTodos($search = null) {
            $query = "SELECT COUNT(*) as total FROM " . $this->tabla;
            if ($search && strlen(trim($search)) > 0) {
                $query .= " WHERE correo LIKE ? OR nombre LIKE ? OR apellido LIKE ? OR telefono LIKE ?";
                $stmt = $this->conexion->prepare($query);
                $like = '%' . $search . '%';
                $stmt->bind_param("ssss", $like, $like, $like, $like);
                $stmt->execute();
                $resultado = $stmt->get_result();
            } else {
                $resultado = $this->conexion->query($query);
            }

            if ($fila = $resultado->fetch_assoc()) {
                return (int)$fila['total'];
            }
            return 0;
        }

    
    /**
     * Obtener un usuario por ID
     */
    public function obtenerPorId($id) {
        $query = "SELECT u.id, u.correo, u.nombre, u.apellido, u.telefono, u.direccion, 
                         u.rol_id, u.activo, u.created_at, r.nombre as rol_nombre 
                  FROM " . $this->tabla . " u 
                  JOIN roles r ON u.rol_id = r.id 
                  WHERE u.id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_assoc();
    }
    
    /**
     * Actualizar usuario
     */
    public function actualizar($id) {
        // Verificar que el usuario no se está borrando a sí mismo
        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $id && $this->activo == 0) {
            return [
                'success' => false,
                'message' => 'No puedes desactivar tu propia cuenta'
            ];
        }
        
        // Validar correo si cambió
        $usuarioActual = $this->obtenerPorId($id);
        if ($usuarioActual['correo'] !== $this->correo && $this->correoExiste($this->correo, $id)) {
            return [
                'success' => false,
                'message' => 'El correo electrónico ya está registrado'
            ];
        }

        if ($usuarioActual['telefono'] !== $this->telefono && $this->telefonoExiste($this->telefono, $id)) {
            return [
                'success' => false,
                'message' => 'El teléfono ya está registrado'
            ];
        }
        
        $query = "UPDATE " . $this->tabla . " 
                  SET correo = ?, nombre = ?, apellido = ?, telefono = ?, direccion = ?, rol_id = ?, activo = ? 
                  WHERE id = ?";
        
        $stmt = $this->conexion->prepare($query);
        
        if (!$stmt) {
            return [
                'success' => false,
                'message' => 'Error al preparar la consulta'
            ];
        }
        
        $stmt->bind_param(
            "ssssssii",
            $this->correo,
            $this->nombre,
            $this->apellido,
            $this->telefono,
            $this->direccion,
            $this->rol_id,
            $this->activo,
            $id
        );
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Usuario actualizado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al actualizar el usuario'
            ];
        }
    }
    
    /**
     * Cambiar contraseña
     */
    public function cambiarClave($id, $claveAntigua, $claveNueva) {
        // Obtener usuario
        $usuario = $this->obtenerPorId($id);
        
        if (!$usuario) {
            return [
                'success' => false,
                'message' => 'Usuario no encontrado'
            ];
        }
        
        // Verificar contraseña antigua
        $query = "SELECT clave FROM " . $this->tabla . " WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuarioData = $resultado->fetch_assoc();
        
        if (!password_verify($claveAntigua, $usuarioData['clave'])) {
            return [
                'success' => false,
                'message' => 'La contraseña actual es incorrecta'
            ];
        }
        
        // Validar nueva contraseña
        if (strlen($claveNueva) < 6) {
            return [
                'success' => false,
                'message' => 'La nueva contraseña debe tener al menos 6 caracteres'
            ];
        }
        
        // Actualizar contraseña
        $claveHasheada = password_hash($claveNueva, PASSWORD_BCRYPT);
        $query = "UPDATE " . $this->tabla . " SET clave = ? WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("si", $claveHasheada, $id);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Contraseña actualizada exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al actualizar la contraseña'
            ];
        }
    }
    
    /**
     * Eliminar usuario (desactivar)
     */
    public function eliminar($id) {
        // Prevenir auto-eliminación
        if (isset($_SESSION['usuario_id']) && $_SESSION['usuario_id'] == $id) {
            return [
                'success' => false,
                'message' => 'No puedes eliminar tu propia cuenta'
            ];
        }
        
        $query = "UPDATE " . $this->tabla . " SET activo = 0 WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Usuario eliminado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al eliminar el usuario'
            ];
        }
    }
    
    /**
     * Reactivar usuario
     */
    public function reactivar($id) {
        $query = "UPDATE " . $this->tabla . " SET activo = 1 WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Usuario reactivado exitosamente'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al reactivar el usuario'
            ];
        }
    }
    /**
 * Verificar si un teléfono ya existe
 */
private function telefonoExiste($telefono, $excluirId = null) {
    $query = "SELECT id FROM " . $this->tabla . " WHERE telefono = ?";

    if ($excluirId) {
        $query .= " AND id != ?";
    }

    $stmt = $this->conexion->prepare($query);
    if (!$stmt) {
        return false; // en caso de error consideramos que no existe (el caller debe manejar)
    }

    if ($excluirId) {
        $stmt->bind_param("si", $telefono, $excluirId);
    } else {
        $stmt->bind_param("s", $telefono);
    }

    $stmt->execute();
    $resultado = $stmt->get_result();

    return $resultado->num_rows > 0;
}
}
?>