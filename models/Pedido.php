<?php
class Pedido {
    private $conexion;
    private $tabla = 'pedidos';

    public $id;
    public $usuario_id;
    public $total;
    public $estado;
    public $direccion_envio;
    public $telefono_envio;

    public function __construct() {
        global $con;
        $this->conexion = $con;
    }

    // Contar pedidos para paginación
    public function contarTodos($search = null) {
        $baseQuery = "SELECT COUNT(*) as total FROM " . $this->tabla;
        if ($search) {
            $like = '%' . $search . '%';
            $stmt = $this->conexion->prepare($baseQuery . " WHERE estado LIKE ?");
            $stmt->bind_param("s", $like);
            $stmt->execute();
            $resultado = $stmt->get_result()->fetch_assoc();
            return $resultado['total'] ?? 0;
        } else {
            $resultado = $this->conexion->query($baseQuery);
            $fila = $resultado->fetch_assoc();
            return $fila['total'] ?? 0;
        }
    }

    // Obtener pedidos con paginación
    public function obtenerTodos($search = null, $limit = null, $offset = null) {
        $baseQuery = "SELECT p.id, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, p.total, p.estado, p.direccion_envio, p.telefono_envio, p.created_at
                      FROM " . $this->tabla . " p
                      JOIN usuarios u ON p.usuario_id = u.id";

        $params = [];
        $types = '';
        if ($search) {
            $baseQuery .= " WHERE p.estado LIKE ?";
            $like = '%' . $search . '%';
            $params[] = &$like;
            $types .= 's';
        }

        $baseQuery .= " ORDER BY p.created_at DESC";

        if ($limit !== null && $offset !== null) {
            $baseQuery .= " LIMIT ? OFFSET ?";
            $params[] = &$limit;
            $params[] = &$offset;
            $types .= 'ii';
        }

        $stmt = $this->conexion->prepare($baseQuery);
        if (!$stmt) return [];

        if (!empty($params)) $stmt->bind_param($types, ...$params);

        $stmt->execute();
        $resultado = $stmt->get_result();
        $pedidos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $pedidos[] = $fila;
        }
        return $pedidos;
    }

    public function obtenerPorId($id) {
        $query = "SELECT p.id, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, p.total, p.estado, p.direccion_envio, p.telefono_envio, p.created_at
                  FROM " . $this->tabla . " p
                  JOIN usuarios u ON p.usuario_id = u.id
                  WHERE p.id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $pedido = $stmt->get_result()->fetch_assoc();
        if ($pedido) {
            // obtener detalle del pedido
            $stmt2 = $this->conexion->prepare("SELECT dp.id, dp.producto_id, pr.nombre AS producto_nombre, dp.cantidad, dp.precio_unitario 
                                               FROM detalle_pedidos dp
                                               JOIN productos pr ON dp.producto_id = pr.id
                                               WHERE dp.pedido_id = ?");
            $stmt2->bind_param("i", $id);
            $stmt2->execute();
            $resultado = $stmt2->get_result();
            $detalle = [];
            while ($fila = $resultado->fetch_assoc()) {
                $detalle[] = $fila;
            }
            $pedido['detalle'] = $detalle;
        }
        return $pedido;
    }

    public function crear($usuario_id, $direccion, $telefono, $items = []) {
        $this->conexion->begin_transaction();
        try {
            $total = 0;
            foreach ($items as $item) {
                $total += $item['precio_unitario'] * $item['cantidad'];
            }

            $stmt = $this->conexion->prepare("INSERT INTO pedidos (usuario_id, total, direccion_envio, telefono_envio) VALUES (?,?,?,?)");
            $stmt->bind_param("idss", $usuario_id, $total, $direccion, $telefono);
            $stmt->execute();
            $pedido_id = $this->conexion->insert_id;

            $stmt_detalle = $this->conexion->prepare("INSERT INTO detalle_pedidos (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?,?,?,?)");
            foreach ($items as $item) {
                $stmt_detalle->bind_param("iiid", $pedido_id, $item['producto_id'], $item['cantidad'], $item['precio_unitario']);
                $stmt_detalle->execute();
            }

            $this->conexion->commit();
            return ['success' => true, 'message' => 'Pedido creado exitosamente', 'pedido_id' => $pedido_id];
        } catch (Exception $e) {
            $this->conexion->rollback();
            return ['success' => false, 'message' => 'Error al crear pedido: ' . $e->getMessage()];
        }
    }

    public function actualizarEstado($id, $estado) {
        $stmt = $this->conexion->prepare("UPDATE pedidos SET estado = ? WHERE id = ?");
        $stmt->bind_param("si", $estado, $id);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Estado actualizado'];
        }
        return ['success' => false, 'message' => 'Error al actualizar estado'];
    }

    public function eliminar($id) {
        $stmt = $this->conexion->prepare("DELETE FROM pedidos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Pedido eliminado'];
        }
        return ['success' => false, 'message' => 'Error al eliminar pedido'];
    }

    public function obtenerPorUsuario($usuario_id) {
    $query = "SELECT p.id, p.total, p.estado, p.direccion_envio, p.telefono_envio, p.created_at
              FROM " . $this->tabla . " p
              WHERE p.usuario_id = ?
              ORDER BY p.created_at DESC";
    
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    $pedidos = [];
    while ($fila = $resultado->fetch_assoc()) {
        $pedidos[] = $fila;
    }
    return $pedidos;
}

/**
 * Obtener pedido por ID con verificación de usuario
 */
public function obtenerPorIdUsuario($id, $usuario_id) {
    $query = "SELECT p.id, u.nombre AS usuario_nombre, u.apellido AS usuario_apellido, 
                     p.total, p.estado, p.direccion_envio, p.telefono_envio, p.created_at
              FROM " . $this->tabla . " p
              JOIN usuarios u ON p.usuario_id = u.id
              WHERE p.id = ? AND p.usuario_id = ?";
    
    $stmt = $this->conexion->prepare($query);
    $stmt->bind_param("ii", $id, $usuario_id);
    $stmt->execute();
    $pedido = $stmt->get_result()->fetch_assoc();
    
    if ($pedido) {
        // Obtener detalle del pedido
        $stmt2 = $this->conexion->prepare("SELECT dp.id, dp.producto_id, pr.nombre AS producto_nombre, 
                                                  pr.imagen, dp.cantidad, dp.precio_unitario 
                                           FROM detalle_pedidos dp
                                           JOIN productos pr ON dp.producto_id = pr.id
                                           WHERE dp.pedido_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $resultado = $stmt2->get_result();
        $detalle = [];
        while ($fila = $resultado->fetch_assoc()) {
            $detalle[] = $fila;
        }
        $pedido['detalle'] = $detalle;
    }
    
    return $pedido;
}

}


?>