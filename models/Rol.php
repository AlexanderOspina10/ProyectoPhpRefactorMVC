<?php
/**
 * Modelo Rol
 * Maneja todas las operaciones relacionadas con roles
 */

class Rol {
    private $conexion;
    private $tabla = 'roles';
    
    public $id;
    public $nombre;
    public $descripcion;
    
    public function __construct() {
        global $con;
        $this->conexion = $con;
    }
    
    /**
     * Obtener todos los roles
     */
    public function obtenerTodos() {
        $query = "SELECT id, nombre, descripcion FROM " . $this->tabla . " ORDER BY nombre ASC";
        $resultado = $this->conexion->query($query);
        
        if (!$resultado) {
            return [];
        }
        
        $roles = [];
        while ($fila = $resultado->fetch_assoc()) {
            $roles[] = $fila;
        }
        
        return $roles;
    }
    
    /**
     * Obtener un rol por ID
     */
    public function obtenerPorId($id) {
        $query = "SELECT id, nombre, descripcion FROM " . $this->tabla . " WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_assoc();
    }
    
    /**
     * Obtener un rol por nombre
     */
    public function obtenerPorNombre($nombre) {
        $query = "SELECT id, nombre, descripcion FROM " . $this->tabla . " WHERE nombre = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_assoc();
    }
}
?>