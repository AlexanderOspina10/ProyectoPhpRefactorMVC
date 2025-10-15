<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Rol.php';
require_once __DIR__ . '/../helpers/functions.php';

class AuthController {
    private $usuarioModel;
    private $rolModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
        $this->rolModel = new Rol();
    }

    /**
     * Mostrar formulario de login
     */
    public function mostrarLogin() {
        if (estaAutenticado()) {
            // Redirigir según el rol
            if ($_SESSION['usuario_rol'] === 'admin') {
                redirect('admin/usuarios');
            } else {
                redirect('');
            }
        }
        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Procesar login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login');
        }

        $correo = limpiarInput($_POST['correo'] ?? '');
        $clave = $_POST['clave'] ?? '';

        if (empty($correo) || empty($clave)) {
            setMensaje('Por favor complete todos los campos', 'error');
            redirect('login');
        }

        $resultado = $this->usuarioModel->login($correo, $clave);

        if ($resultado['success']) {
            $usuario = $resultado['usuario'];

            // Guardar variables de sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_correo'] = $usuario['correo'];
            $_SESSION['usuario_rol'] = $usuario['rol_nombre'];

            setMensaje('Bienvenido ' . htmlspecialchars($usuario['nombre']), 'success');

            // Redirigir según el rol
            if ($usuario['rol_nombre'] === 'admin') {
                redirect('admin/usuarios');
            } else {
                redirect('');
            }

        } else {
            setMensaje($resultado['message'], 'error');
            redirect('login');
        }
    }

    /**
     * Mostrar formulario de registro
     */
    public function mostrarRegistro() {
        if (estaAutenticado()) {
            if ($_SESSION['usuario_rol'] === 'admin') {
                redirect('admin/usuarios');
            } else {
                redirect('');
            }
        }

        $roles = $this->rolModel->obtenerTodos();
        require_once __DIR__ . '/../views/auth/registro.php';
    }

    /**
     * Procesar registro
     */
    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('registro');
        }

        $this->usuarioModel->correo = limpiarInput($_POST['correo'] ?? '');
        $this->usuarioModel->nombre = limpiarInput($_POST['nombre'] ?? '');
        $this->usuarioModel->apellido = limpiarInput($_POST['apellido'] ?? '');
        $this->usuarioModel->telefono = limpiarInput($_POST['telefono'] ?? '');
        $this->usuarioModel->direccion = limpiarInput($_POST['direccion'] ?? '');
        $this->usuarioModel->rol_id = $_POST['rol_id'] ?? 2; // Por defecto rol usuario
        $this->usuarioModel->clave = $_POST['clave'] ?? '';

        // Validaciones
        if (empty($this->usuarioModel->correo) || empty($this->usuarioModel->nombre) || 
            empty($this->usuarioModel->apellido) || empty($this->usuarioModel->clave)) {
            setMensaje('Por favor complete todos los campos obligatorios', 'error');
            redirect('registro');
        }

        if (!filter_var($this->usuarioModel->correo, FILTER_VALIDATE_EMAIL)) {
            setMensaje('El correo electrónico no es válido', 'error');
            redirect('registro');
        }

        $resultado = $this->usuarioModel->crear();

        if ($resultado['success']) {
            setMensaje('Registro exitoso. Por favor inicia sesión', 'success');
            redirect('login');
        } else {
            setMensaje($resultado['message'], 'error');
            redirect('registro');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params['path'], $params['domain'],
                    $params['secure'], $params['httponly']
                );
            }
            session_destroy();
        }

        // Reiniciar sesión para mostrar mensaje
        session_start();
        setMensaje('Sesión cerrada exitosamente', 'success');
        redirect('login');
    }

    /**
     * Cierre forzado (sin mensaje, cuando expira la sesión)
     */
    public function forceLogout() {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
        }

        header('Location: ' . baseUrl('login'));
        exit;
    }
}
