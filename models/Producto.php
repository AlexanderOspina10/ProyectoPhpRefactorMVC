<?php
class Producto {
    private $conexion;
    private $tabla = 'productos';

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $categoria;
    public $stock;
    public $imagen;
    public $activo;

    public function __construct() {
        global $con;
        $this->conexion = $con;
    }

    // Contar productos (para paginación)
    public function contarTodos($search = null) {
        $baseQuery = "SELECT COUNT(*) as total FROM " . $this->tabla;
        if ($search && strlen(trim($search)) > 0) {
            $like = '%' . $search . '%';
            $stmt = $this->conexion->prepare($baseQuery . " WHERE nombre LIKE ? OR categoria LIKE ?");
            $stmt->bind_param("ss", $like, $like);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_assoc();
            return $resultado['total'] ?? 0;
        } else {
            $resultado = $this->conexion->query($baseQuery);
            $fila = $resultado->fetch_assoc();
            return $fila['total'] ?? 0;
        }
    }

    // Obtener productos con paginación
    public function obtenerTodos($search = null, $limit = null, $offset = null) {
        $baseQuery = "SELECT id, nombre, descripcion, precio, categoria, stock, imagen, activo, created_at
                      FROM " . $this->tabla;
        $params = [];
        $types = '';
        if ($search && strlen(trim($search)) > 0) {
            $baseQuery .= " WHERE nombre LIKE ? OR categoria LIKE ?";
            $like = '%' . $search . '%';
            $params[] = &$like;
            $params[] = &$like;
            $types .= 'ss';
        }

        $baseQuery .= " ORDER BY created_at DESC";

        if ($limit !== null && $offset !== null) {
            $baseQuery .= " LIMIT ? OFFSET ?";
            $params[] = &$limit;
            $params[] = &$offset;
            $types .= 'ii';
        }

        $stmt = $this->conexion->prepare($baseQuery);
        if (!$stmt) return [];

        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $resultado = $stmt->get_result();
        $productos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }
        return $productos;
    }

        public function obtenerPorId($id) {
            $query = "SELECT id, nombre, descripcion, precio, categoria, stock, imagen, activo, created_at
                    FROM " . $this->tabla . " WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_assoc();
        }

        public function crear() {
        $query = "INSERT INTO " . $this->tabla . " (nombre, descripcion, precio, categoria, stock, imagen, activo)
                VALUES (?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->conexion->prepare($query);
        if (!$stmt) return ['success' => false, 'message' => 'Error al preparar la consulta'];

        $stmt->bind_param(
            "ssdsis", 
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->categoria,
            $this->stock,
            $this->imagen
        );

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Producto creado exitosamente', 'producto_id' => $this->conexion->insert_id];
        } else {
            return ['success' => false, 'message' => 'Error al crear el producto: ' . $this->conexion->error];
        }
    }

    public function actualizar($id) {
        $productoActual = $this->obtenerPorId($id);
        if (!$productoActual) {
            return ['success' => false, 'message' => 'Producto no encontrado'];
        }

        $imagenFinal = !empty($this->imagen) ? $this->imagen : $productoActual['imagen'];

        $query = "UPDATE " . $this->tabla . " 
                SET nombre = ?, descripcion = ?, precio = ?, categoria = ?, stock = ?, imagen = ?, activo = ? 
                WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        if (!$stmt) return ['success' => false, 'message' => 'Error al preparar la consulta'];

        $stmt->bind_param(
            "ssdsisii", // <- cambiar 6º parámetro (imagen) a 's'
            $this->nombre,
            $this->descripcion,
            $this->precio,
            $this->categoria,
            $this->stock,
            $imagenFinal,
            $this->activo,
            $id
        );

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Producto actualizado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar el producto: ' . $this->conexion->error];
        }
    }


    public function eliminar($id) {
        $query = "UPDATE " . $this->tabla . " SET activo = 0 WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Producto eliminado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al eliminar el producto'];
        }
    }

    public function reactivar($id) {
        $query = "UPDATE " . $this->tabla . " SET activo = 1 WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Producto reactivado exitosamente'];
        } else {
            return ['success' => false, 'message' => 'Error al reactivar el producto'];
        }
    }
}
?>
