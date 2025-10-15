<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../models/Contacto.php';
require_once __DIR__ . '/../helpers/functions.php';

class DashboardController {
    private $usuarioModel;
    private $productoModel;
    private $pedidoModel;
    private $contactoModel;

    public function __construct() {
        requiereRol('admin');
        $this->usuarioModel = new Usuario();
        $this->productoModel = new Producto();
        $this->pedidoModel = new Pedido();
        $this->contactoModel = new Contacto();
    }

    public function index() {
        // Estadísticas principales
        $totalUsuarios = $this->usuarioModel->contarTodos();
        $totalProductos = $this->productoModel->contarTodos();
        $totalPedidos = $this->pedidoModel->contarTodos();
        $totalMensajes = $this->contactoModel->contarTodos();
        $mensajesNoLeidos = $this->contactoModel->contarNoLeidos();

        // Últimos 5 usuarios
        $ultimosUsuarios = $this->usuarioModel->obtenerTodos(null, 5, 0);

        // Últimos 5 productos
        $ultimosProductos = $this->productoModel->obtenerTodos(null, 5, 0);

        // Últimos 5 pedidos
        $ultimosPedidos = $this->pedidoModel->obtenerTodos(null, 5, 0);

        // Últimos 5 mensajes no leídos
        $ultimosMensajes = $this->contactoModel->obtenerNoLeidos(5);

        $titulo = 'Dashboard - Resumen General';
        
        // Pasar las variables necesarias al header
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/dashboard/index.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }
}
?>