<?php
require_once __DIR__ . '/../models/Pedido.php';
require_once __DIR__ . '/../helpers/functions.php';

class PedidoController {
    private $pedidoModel;

    public function __construct() {
        requiereRol('admin');
        $this->pedidoModel = new Pedido();
    }

    public function index() {
        $q = $_GET['q'] ?? '';
        $limit = (int)($_GET['limit'] ?? 5);
        $page = (int)($_GET['page'] ?? 1);
        $offset = ($page - 1) * $limit;

        $totalPedidos = $this->pedidoModel->contarTodos($q ?: null);
        $pedidos = $this->pedidoModel->obtenerTodos($q ?: null, $limit, $offset);
        $totalPaginas = ceil($totalPedidos / $limit);

        $titulo = 'Gestión de Pedidos';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/pedidos/index.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function ver($id) {
        $pedido = $this->pedidoModel->obtenerPorId($id);
        if (!$pedido) {
            setMensaje('Pedido no encontrado', 'error');
            redirect('admin/pedidos');
        }
        $titulo = 'Detalle del Pedido';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/pedidos/ver.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/pedidos');

        $id = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? 'pendiente';

        $resultado = $this->pedidoModel->actualizarEstado($id, $estado);
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect('admin/pedidos/ver/' . $id);
    }

    public function eliminar($id) {
        $resultado = $this->pedidoModel->eliminar($id);
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect('admin/pedidos');
    }
}
?>