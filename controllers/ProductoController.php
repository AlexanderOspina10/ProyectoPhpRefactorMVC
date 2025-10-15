<?php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/functions.php';

class ProductoController {
    private $productoModel;

    public function __construct() {
        requiereRol('admin');
        $this->productoModel = new Producto();
    }

    public function index() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5; // <- por defecto 5
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalProductos = $this->productoModel->contarTodos($q ?: null);
        $productos = $this->productoModel->obtenerTodos($q ?: null, $limit, $offset);

        $totalPaginas = ceil($totalProductos / $limit);

        $titulo = 'Gestión de Productos';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/productos/index.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function crear() {
        $titulo = 'Crear Producto';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/productos/crear.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/productos/crear');

        if (!isset($_POST['csrf_token']) || !verificarTokenCSRF($_POST['csrf_token'])) {
            setMensaje('Token de seguridad inválido', 'error');
            redirect('admin/productos/crear');
        }

        $this->productoModel->nombre = limpiarInput($_POST['nombre'] ?? '');
        $this->productoModel->descripcion = limpiarInput($_POST['descripcion'] ?? '');
        $this->productoModel->precio = floatval(str_replace(',', '.', $_POST['precio'] ?? 0));
        $this->productoModel->categoria = limpiarInput($_POST['categoria'] ?? '');
        $this->productoModel->stock = (int)($_POST['stock'] ?? 0);

        if (empty($this->productoModel->nombre) || $this->productoModel->precio <= 0) {
            setMensaje('Nombre y precio son obligatorios (precio > 0)', 'error');
            redirect('admin/productos/crear');
        }

        // Manejo de imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            $res = subirImagen($_FILES['imagen'], 'uploads/products');
            if ($res['success']) {
                $this->productoModel->imagen = $res['filename'];
            } else {
                setMensaje('Error subiendo imagen: ' . $res['message'], 'error');
                redirect('admin/productos/crear');
            }
        }

        $resultado = $this->productoModel->crear();
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect($resultado['success'] ? 'admin/productos' : 'admin/productos/crear');
    }

    public function editar($id) {
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            setMensaje('Producto no encontrado', 'error');
            redirect('admin/productos');
        }
        $titulo = 'Editar Producto';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/productos/editar.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') redirect('admin/productos');

        if (!isset($_POST['csrf_token']) || !verificarTokenCSRF($_POST['csrf_token'])) {
            setMensaje('Token de seguridad inválido', 'error');
            redirect('admin/productos');
        }

        $id = (int)($_POST['id'] ?? 0);
        if ($id === 0) {
            setMensaje('Producto no especificado', 'error');
            redirect('admin/productos');
        }

        $this->productoModel->nombre = limpiarInput($_POST['nombre'] ?? '');
        $this->productoModel->descripcion = limpiarInput($_POST['descripcion'] ?? '');
        $this->productoModel->precio = floatval(str_replace(',', '.', $_POST['precio'] ?? 0));
        $this->productoModel->categoria = limpiarInput($_POST['categoria'] ?? '');
        $this->productoModel->stock = (int)($_POST['stock'] ?? 0);
        $this->productoModel->activo = (int)($_POST['activo'] ?? 1);

        if (empty($this->productoModel->nombre) || $this->productoModel->precio <= 0) {
            setMensaje('Nombre y precio son obligatorios (precio > 0)', 'error');
            redirect('admin/productos/editar/' . $id);
        }

        // Manejo de imagen
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE) {
            $res = subirImagen($_FILES['imagen'], 'uploads/products');
            if ($res['success']) {
                $this->productoModel->imagen = $res['filename'];
            } // Si falla, se mantiene la imagen anterior
        }

        $resultado = $this->productoModel->actualizar($id);
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect($resultado['success'] ? 'admin/productos' : 'admin/productos/editar/' . $id);
    }

    public function eliminar($id) {
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            setMensaje('Producto no encontrado', 'error');
            redirect('admin/productos');
        }
        $resultado = $this->productoModel->eliminar($id);
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect('admin/productos');
    }

    public function reactivar($id) {
        $resultado = $this->productoModel->reactivar($id);
        setMensaje($resultado['message'], $resultado['success'] ? 'success' : 'error');
        redirect('admin/productos');
    }
}
?>
