<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../helpers/functions.php';

class PedidosUsuarioController {
    private $pedidoModel;
    private $usuarioModel;

    public function __construct() {
        // Requerir autenticación pero no rol específico
        if (!estaAutenticado()) {
            setMensaje('Debes iniciar sesión para acceder a esta página', 'error');
            redirect('login');
        }
        
        $this->pedidoModel = new Pedido();
        $this->usuarioModel = new Usuario();
    }

    /**
     * Página para finalizar pedido
     */
    public function finalizar() {
        // Verificar que el carrito no esté vacío
        if (empty($_SESSION['carrito'])) {
            setMensaje('El carrito está vacío', 'error');
            redirect('catalogo');
        }

        // Obtener información del usuario
        $usuario = $this->usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        if (!$usuario) {
            setMensaje('Error al cargar información del usuario', 'error');
            redirect('catalogo');
        }

        // Calcular total
        $total = 0;
        foreach ($_SESSION['carrito'] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        $titulo = 'Finalizar Pedido - Fashion Store';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/pedidosUsuario/finalizar.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }

    /**
     * Procesar el pedido
     */
    public function procesar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMensaje('Método no permitido', 'error');
            redirect('pedidosUsuario/finalizar');
        }

        // Verificar que el carrito no esté vacío
        if (empty($_SESSION['carrito'])) {
            setMensaje('El carrito está vacío', 'error');
            redirect('catalogo');
        }

        // Validar datos del formulario
        $direccion = trim($_POST['direccion'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $notas = trim($_POST['notas'] ?? '');

        if (empty($direccion) || empty($telefono)) {
            setMensaje('Por favor completa todos los campos obligatorios', 'error');
            redirect('pedidosUsuario/finalizar');
        }

        // Preparar items para el pedido
        $items = [];
        foreach ($_SESSION['carrito'] as $item) {
            $items[] = [
                'producto_id' => $item['producto_id'],
                'cantidad' => $item['cantidad'],
                'precio_unitario' => $item['precio']
            ];
        }

        // Crear el pedido
        $resultado = $this->pedidoModel->crear(
            $_SESSION['usuario_id'],
            $direccion,
            $telefono,
            $items
        );

        if ($resultado['success']) {
            // Limpiar carrito
            $_SESSION['carrito'] = [];
            
            setMensaje('¡Pedido realizado con éxito! Número de pedido: #' . $resultado['pedido_id'], 'success');
            redirect('pedidosUsuario/mis_pedidos');
        } else {
            setMensaje('Error al procesar el pedido: ' . $resultado['message'], 'error');
            redirect('pedidosUsuario/finalizar');
        }
    }

    /**
     * Mostrar pedidos del usuario
     */
    public function mis_pedidos() {
        $pedidos = $this->pedidoModel->obtenerPorUsuario($_SESSION['usuario_id']);

        $titulo = 'Mis Pedidos - Fashion Store';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/pedidosUsuario/mis_pedidos.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }

    /**
     * Ver detalle de un pedido específico
     */
    public function ver($id) {
        $pedido = $this->pedidoModel->obtenerPorIdUsuario($id, $_SESSION['usuario_id']);
        
        if (!$pedido) {
            setMensaje('Pedido no encontrado', 'error');
            redirect('pedidosUsuario/mis_pedidos');
        }

        $titulo = 'Detalle del Pedido #' . $pedido['id'] . ' - Fashion Store';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/pedidosUsuario/ver.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }
}