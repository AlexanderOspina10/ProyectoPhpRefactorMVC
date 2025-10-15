<?php
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../models/Producto.php';

class CarritoController {
    private $productoModel;
    
    public function __construct() {
        $this->productoModel = new Producto();
        // Inicializar carrito en sesión si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar($producto_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMensaje('Método no permitido', 'error');
            redirect('');
        }

        $cantidad = (int)($_POST['cantidad'] ?? 1);
        
        if ($cantidad <= 0) {
            setMensaje('La cantidad debe ser mayor a 0', 'error');
            redirect('');
        }

        // Obtener información real del producto
        $producto = $this->productoModel->obtenerPorId($producto_id);
        
        if (!$producto || (int)$producto['activo'] !== 1) {
            setMensaje('Producto no encontrado o no disponible', 'error');
            redirect('');
        }

        // Verificar si el producto ya está en el carrito
        $enCarrito = false;
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['producto_id'] == $producto_id) {
                $item['cantidad'] += $cantidad;
                $enCarrito = true;
                break;
            }
        }

        // Si no está en el carrito, agregarlo
        if (!$enCarrito) {
            $_SESSION['carrito'][] = [
                'producto_id' => $producto_id,
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'imagen' => $producto['imagen'] ?? '',
                'cantidad' => $cantidad
            ];
        }

        setMensaje('Producto agregado al carrito', 'success');
        
        // Redirigir de vuelta a la página anterior
        $referer = $_SERVER['HTTP_REFERER'] ?? baseUrl('');
        header('Location: ' . $referer);
        exit;
    }

    /**
     * Actualizar cantidad de producto en carrito
     */
    public function actualizar($producto_id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            return;
        }

        $cantidad = (int)($_POST['cantidad'] ?? 1);
        
        if ($cantidad <= 0) {
            // Si la cantidad es 0 o menor, eliminar el producto
            $this->eliminar($producto_id);
            echo json_encode(['success' => true, 'message' => 'Producto eliminado']);
            return;
        }

        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['producto_id'] == $producto_id) {
                $item['cantidad'] = $cantidad;
                echo json_encode(['success' => true, 'message' => 'Cantidad actualizada']);
                return;
            }
        }

        echo json_encode(['success' => false, 'message' => 'Producto no encontrado en carrito']);
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar($producto_id) {
        foreach ($_SESSION['carrito'] as $index => $item) {
            if ($item['producto_id'] == $producto_id) {
                array_splice($_SESSION['carrito'], $index, 1);
                setMensaje('Producto eliminado del carrito', 'success');
                
                $referer = $_SERVER['HTTP_REFERER'] ?? baseUrl('');
                header('Location: ' . $referer);
                exit;
            }
        }

        setMensaje('Producto no encontrado en carrito', 'error');
        redirect('');
    }

    /**
     * Vaciar carrito
     */
    public function vaciar() {
        $_SESSION['carrito'] = [];
        setMensaje('Carrito vaciado', 'success');
        redirect('');
    }

    /**
     * Mostrar panel del carrito (para AJAX)
     */
    public function mostrarPanel() {
        $carrito = $_SESSION['carrito'] ?? [];
        $total = 0;
        
        foreach ($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        require_once __DIR__ . '/../views/carrito/panel.php';
    }

    /**
     * Finalizar pedido (solo para usuarios logueados)
     */
    public function finalizar() {
        if (!estaAutenticado()) {
            setMensaje('Debes iniciar sesión para finalizar tu pedido', 'error');
            redirect('login');
        }

        if (empty($_SESSION['carrito'])) {
            setMensaje('El carrito está vacío', 'error');
            redirect('');
        }

        // Aquí iría la lógica para crear el pedido en la base de datos
        require_once __DIR__ . '/../views/carrito/checkout.php';
    }
}