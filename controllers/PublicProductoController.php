<?php
// controllers/PublicProductoController.php
require_once __DIR__ . '/../models/Producto.php';
require_once __DIR__ . '/../helpers/functions.php';

class PublicProductoController {
    private $productoModel;

    public function __construct() {
        $this->productoModel = new Producto();
    }

    /**
     * Página pública principal / landing con listado de productos activos
     * URL sugerida: / (o /catalogo)
     */
    public function landing() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        // Obtener todos (puedes filtrar por activo en el modelo o aquí)
        // El modelo obtenerTodos no filtra por activo, así que filtraremos sobre el resultado.
        $totalProductos = 0;
        $productos = $this->productoModel->obtenerTodos($q ?: null, null, null);

        // Filtrar activos y búsqueda (si se prefiere hacerlo aquí)
        $productosActivos = array_filter($productos, function($p) use ($q) {
            if (!isset($p['activo']) || (int)$p['activo'] !== 1) return false;
            if ($q === '') return true;
            $qLower = mb_strtolower($q);
            return (mb_strpos(mb_strtolower($p['nombre']), $qLower) !== false)
                || (mb_strpos(mb_strtolower($p['categoria']), $qLower) !== false);
        });

        $totalProductos = count($productosActivos);

        // Paginación manual sobre el arreglo (porque ya obtuvimos todos para filtrar por activo)
        $productosActivos = array_values($productosActivos);
        $productosPaginados = array_slice($productosActivos, $offset, $limit);

        $totalPaginas = $limit > 0 ? ceil($totalProductos / $limit) : 1;

        $titulo = 'Fashion Store - Inicio';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/usuario/home/landing.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }

    /**
     * (Opcional) Ver detalle de producto público
     */
    public function ver($id) {
        $producto = $this->productoModel->obtenerPorId((int)$id);
        if (!$producto || (int)$producto['activo'] !== 1) {
            setMensaje('Producto no encontrado', 'error');
            redirect('');
        }
        $titulo = $producto['nombre'] . ' - Fashion Store';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/usuario/productos/ver.php'; // si quieres crear detalle
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }
}
?>
