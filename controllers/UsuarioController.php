<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../helpers/functions.php';

class UsuarioController {
    private $usuarioModel;
    private $rolModel;
    
    public function __construct() {
        requiereRol('admin');
        $this->usuarioModel = new Usuario();
        $this->rolModel = new Rol();
    }
    
    /**
     * Listar todos los usuarios
     */
    public function index() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5; // Cambiado a 5 por defecto
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalUsuarios = $this->usuarioModel->contarTodos($q ?: null);
        $usuarios = $this->usuarioModel->obtenerTodos($q ?: null, $limit, $offset);

        $totalPaginas = ceil($totalUsuarios / $limit);

        $titulo = 'Gestión de Usuarios';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/usuarios/index.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }

    public function crear() {
        $roles = $this->rolModel->obtenerTodos();
        $titulo = 'Crear Nuevo Usuario';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/usuarios/crear.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }
    
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/usuarios/crear');
        }
        
        if (!isset($_POST['csrf_token']) || !verificarTokenCSRF($_POST['csrf_token'])) {
            setMensaje('Token de seguridad inválido', 'error');
            redirect('admin/usuarios/crear');
        }
        
        $this->usuarioModel->correo = limpiarInput($_POST['correo'] ?? '');
        $this->usuarioModel->nombre = limpiarInput($_POST['nombre'] ?? '');
        $this->usuarioModel->apellido = limpiarInput($_POST['apellido'] ?? '');
        $this->usuarioModel->telefono = limpiarInput($_POST['telefono'] ?? '');
        $this->usuarioModel->direccion = limpiarInput($_POST['direccion'] ?? '');
        $this->usuarioModel->rol_id = (int)($_POST['rol_id'] ?? 2);
        $this->usuarioModel->clave = $_POST['clave'] ?? '';
        
        if (empty($this->usuarioModel->correo) || empty($this->usuarioModel->nombre) || 
            empty($this->usuarioModel->apellido) || empty($this->usuarioModel->telefono) ||
            empty($this->usuarioModel->direccion) || empty($this->usuarioModel->clave)) {
            setMensaje('Por favor completa todos los campos', 'error');
            redirect('admin/usuarios/crear');
        }
        
        if (!esEmailValido($this->usuarioModel->correo)) {
            setMensaje('El correo electrónico no es válido', 'error');
            redirect('admin/usuarios/crear');
        }
        
        if (!esTelefonoValido($this->usuarioModel->telefono)) {
            setMensaje('El teléfono debe contener entre 7 y 15 dígitos', 'error');
            redirect('admin/usuarios/crear');
        }
        
        $resultado = $this->usuarioModel->crear();
        
        if ($resultado['success']) {
            setMensaje('Usuario creado exitosamente', 'success');
            redirect('admin/usuarios');
        } else {
            setMensaje($resultado['message'], 'error');
            redirect('admin/usuarios/crear');
        }
    }
    
    public function editar($id) {
        $usuario = $this->usuarioModel->obtenerPorId($id);
        
        if (!$usuario) {
            setMensaje('Usuario no encontrado', 'error');
            redirect('admin/usuarios');
        }
        
        $roles = $this->rolModel->obtenerTodos();
        $titulo = 'Editar Usuario';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/usuarios/editar.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }
    
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin/usuarios');
        }
        
        if (!isset($_POST['csrf_token']) || !verificarTokenCSRF($_POST['csrf_token'])) {
            setMensaje('Token de seguridad inválido', 'error');
            redirect('admin/usuarios');
        }
        
        $id = (int)($_POST['id'] ?? 0);
        
        if ($id === 0) {
            setMensaje('Usuario no especificado', 'error');
            redirect('admin/usuarios');
        }
        
        $this->usuarioModel->correo = limpiarInput($_POST['correo'] ?? '');
        $this->usuarioModel->nombre = limpiarInput($_POST['nombre'] ?? '');
        $this->usuarioModel->apellido = limpiarInput($_POST['apellido'] ?? '');
        $this->usuarioModel->telefono = limpiarInput($_POST['telefono'] ?? '');
        $this->usuarioModel->direccion = limpiarInput($_POST['direccion'] ?? '');
        $this->usuarioModel->rol_id = (int)($_POST['rol_id'] ?? 2);
        $this->usuarioModel->activo = (int)($_POST['activo'] ?? 1);
        
        if (empty($this->usuarioModel->correo) || empty($this->usuarioModel->nombre) || 
            empty($this->usuarioModel->apellido) || empty($this->usuarioModel->telefono) ||
            empty($this->usuarioModel->direccion)) {
            setMensaje('Por favor completa todos los campos', 'error');
            redirect('admin/usuarios/editar/' . $id);
        }
        
        if (!esEmailValido($this->usuarioModel->correo)) {
            setMensaje('El correo electrónico no es válido', 'error');
            redirect('admin/usuarios/editar/' . $id);
        }
        
        if (!esTelefonoValido($this->usuarioModel->telefono)) {
            setMensaje('El teléfono debe contener entre 7 y 15 dígitos', 'error');
            redirect('admin/usuarios/editar/' . $id);
        }
        
        $resultado = $this->usuarioModel->actualizar($id);
        
        if ($resultado['success']) {
            setMensaje('Usuario actualizado exitosamente', 'success');
            redirect('admin/usuarios');
        } else {
            setMensaje($resultado['message'], 'error');
            redirect('admin/usuarios/editar/' . $id);
        }
    }
    
    public function eliminar($id) {
        $usuario = $this->usuarioModel->obtenerPorId($id);
        
        if (!$usuario) {
            setMensaje('Usuario no encontrado', 'error');
            redirect('admin/usuarios');
        }
        
        $resultado = $this->usuarioModel->eliminar($id);
        
        if ($resultado['success']) {
            setMensaje('Usuario eliminado exitosamente', 'success');
        } else {
            setMensaje($resultado['message'], 'error');
        }
        
        redirect('admin/usuarios');
    }
}
?>
