<?php
/**
 * Modelo Contacto
 * Maneja todas las operaciones relacionadas con mensajes de contacto
 */

class Contacto {
    private $conexion;
    private $tabla = 'mensajes_contacto';
    
    public $id;
    public $nombre;
    public $correo;
    public $asunto;
    public $mensaje;
    public $leido;
    
    public function __construct() {
        global $con;
        $this->conexion = $con;
    }
    
    /**
     * Crear un nuevo mensaje de contacto
     */
    public function crear() {
        $query = "INSERT INTO " . $this->tabla . " 
                  (nombre, correo, asunto, mensaje) 
                  VALUES (?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($query);
        
        if (!$stmt) {
            return [
                'success' => false,
                'message' => 'Error al preparar la consulta: ' . $this->conexion->error
            ];
        }
        
        $stmt->bind_param(
            "ssss",
            $this->nombre,
            $this->correo,
            $this->asunto,
            $this->mensaje
        );
        
        if ($stmt->execute()) {
            return [
                'success' => true,
                'message' => 'Mensaje enviado exitosamente',
                'id' => $this->conexion->insert_id
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Error al enviar el mensaje: ' . $stmt->error
            ];
        }
    }
    
    /**
     * Obtener todos los mensajes (para admin)
     */
    public function obtenerTodos($limit = 10, $offset = 0) {
        $query = "SELECT * FROM " . $this->tabla . " 
                  ORDER BY created_at DESC 
                  LIMIT ? OFFSET ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $mensajes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $mensajes[] = $fila;
        }
        
        return $mensajes;
    }
    
    /**
     * Obtener todos los mensajes con búsqueda
     */
    public function obtenerTodosConBusqueda($search = null, $limit = 10, $offset = 0) {
        $baseQuery = "SELECT * FROM " . $this->tabla;
        
        if ($search && strlen(trim($search)) > 0) {
            $like = '%' . $search . '%';
            $query = $baseQuery . " WHERE (nombre LIKE ? OR correo LIKE ? OR asunto LIKE ? OR mensaje LIKE ?) 
                                    ORDER BY created_at DESC 
                                    LIMIT ? OFFSET ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ssssii", $like, $like, $like, $like, $limit, $offset);
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $query = $baseQuery . " ORDER BY created_at DESC LIMIT ? OFFSET ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("ii", $limit, $offset);
            $stmt->execute();
            $resultado = $stmt->get_result();
        }
        
        $mensajes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $mensajes[] = $fila;
        }
        
        return $mensajes;
    }
    
    /**
     * Obtener un mensaje por ID
     */
    public function obtenerPorId($id) {
        $query = "SELECT * FROM " . $this->tabla . " WHERE id = ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_assoc();
    }
    
    /**
     * Marcar mensaje como leído
     */
    public function marcarLeido($id) {
        $query = "UPDATE " . $this->tabla . " SET leido = 1 WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Contar mensajes no leídos
     */
    public function contarNoLeidos() {
        $query = "SELECT COUNT(*) as total FROM " . $this->tabla . " WHERE leido = 0";
        $resultado = $this->conexion->query($query);
        
        if ($fila = $resultado->fetch_assoc()) {
            return (int)$fila['total'];
        }
        return 0;
    }
    
    /**
     * Contar total de mensajes
     */
    public function contarTodos($search = null) {
        if ($search && strlen(trim($search)) > 0) {
            $query = "SELECT COUNT(*) as total FROM " . $this->tabla . 
                     " WHERE nombre LIKE ? OR correo LIKE ? OR asunto LIKE ? OR mensaje LIKE ?";
            $stmt = $this->conexion->prepare($query);
            $like = '%' . $search . '%';
            $stmt->bind_param("ssss", $like, $like, $like, $like);
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->tabla;
            $resultado = $this->conexion->query($query);
        }
        
        if ($fila = $resultado->fetch_assoc()) {
            return (int)$fila['total'];
        }
        return 0;
    }
    
    /**
     * Contar mensajes por estado de lectura
     */
    public function contarPorEstado($leido = null) {
        if ($leido !== null) {
            $query = "SELECT COUNT(*) as total FROM " . $this->tabla . " WHERE leido = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $leido);
            $stmt->execute();
            $resultado = $stmt->get_result();
        } else {
            $query = "SELECT COUNT(*) as total FROM " . $this->tabla;
            $resultado = $this->conexion->query($query);
        }
        
        if ($fila = $resultado->fetch_assoc()) {
            return (int)$fila['total'];
        }
        return 0;
    }
    
    /**
     * Eliminar mensaje
     */
    public function eliminar($id) {
        $query = "DELETE FROM " . $this->tabla . " WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }
    
    /**
     * Obtener mensajes no leídos para el dashboard
     */
    public function obtenerNoLeidos($limit = 5) {
        $query = "SELECT * FROM " . $this->tabla . " 
                  WHERE leido = 0 
                  ORDER BY created_at DESC 
                  LIMIT ?";
        
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        $mensajes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $mensajes[] = $fila;
        }
        
        return $mensajes;
    }
}
?>