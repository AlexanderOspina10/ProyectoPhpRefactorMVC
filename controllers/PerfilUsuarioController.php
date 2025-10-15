<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../helpers/functions.php';

class PerfilUsuarioController {
    private $usuarioModel;

    public function __construct() {
        // Requerir autenticación pero no rol específico
        if (!estaAutenticado()) {
            setMensaje('Debes iniciar sesión para acceder a esta página', 'error');
            redirect('login');
        }
        
        $this->usuarioModel = new Usuario();
    }

    /**
     * Mostrar perfil del usuario
     */
    public function perfil() {
        $usuario = $this->usuarioModel->obtenerPorId($_SESSION['usuario_id']);
        
        if (!$usuario) {
            setMensaje('Error al cargar información del usuario', 'error');
            redirect('');
        }

        $titulo = 'Mi Perfil - Fashion Store';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/perfilUsuario/perfil.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }

    /**
     * Actualizar información del perfil
     */
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMensaje('Método no permitido', 'error');
            redirect('perfilUsuario/perfil');
        }

        $id = $_SESSION['usuario_id'];
        
        // Obtener datos del formulario
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');

        // Validaciones
        if (empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion)) {
            setMensaje('Por favor completa todos los campos obligatorios', 'error');
            redirect('perfilUsuario/perfil');
        }

        if (!esTelefonoValido($telefono)) {
            setMensaje('El teléfono debe contener entre 7 y 15 dígitos', 'error');
            redirect('perfilUsuario/perfil');
        }

        // Obtener el usuario actual para mantener el correo y otros campos necesarios
        $usuarioActual = $this->usuarioModel->obtenerPorId($id);
        if (!$usuarioActual) {
            setMensaje('Error al cargar información del usuario', 'error');
            redirect('perfilUsuario/perfil');
        }

        // Actualizar usuario - incluir el correo y otros campos requeridos
        $this->usuarioModel->nombre = $nombre;
        $this->usuarioModel->apellido = $apellido;
        $this->usuarioModel->telefono = $telefono;
        $this->usuarioModel->direccion = $direccion;
        $this->usuarioModel->correo = $usuarioActual['correo']; // Mantener el correo actual
        $this->usuarioModel->activo = 1;

        // Si el modelo tiene otros campos requeridos, también deberían asignarse aquí
        if (isset($usuarioActual['rol_id'])) {
            $this->usuarioModel->rol_id = $usuarioActual['rol_id'];
        }

        $resultado = $this->usuarioModel->actualizar($id);

        if ($resultado['success']) {
            // Actualizar datos en sesión
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_apellido'] = $apellido;
            
            setMensaje('Perfil actualizado exitosamente', 'success');
        } else {
            setMensaje($resultado['message'], 'error');
        }

        redirect('perfilUsuario/perfil');
    }

    /**
     * Cambiar contraseña
     */
    public function cambiarClave() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMensaje('Método no permitido', 'error');
            redirect('perfilUsuario/perfil');
        }

        $id = $_SESSION['usuario_id'];
        $claveActual = $_POST['clave_actual'] ?? '';
        $claveNueva = $_POST['clave_nueva'] ?? '';
        $claveConfirmar = $_POST['clave_confirmar'] ?? '';

        // Validaciones
        if (empty($claveActual) || empty($claveNueva) || empty($claveConfirmar)) {
            setMensaje('Por favor completa todos los campos de contraseña', 'error');
            redirect('perfilUsuario/perfil');
        }

        if ($claveNueva !== $claveConfirmar) {
            setMensaje('Las contraseñas nuevas no coinciden', 'error');
            redirect('perfilUsuario/perfil');
        }

        if (strlen($claveNueva) < 6) {
            setMensaje('La nueva contraseña debe tener al menos 6 caracteres', 'error');
            redirect('perfilUsuario/perfil');
        }

        // Cambiar contraseña
        $resultado = $this->usuarioModel->cambiarClave($id, $claveActual, $claveNueva);

        if ($resultado['success']) {
            setMensaje('Contraseña actualizada exitosamente', 'success');
        } else {
            setMensaje($resultado['message'], 'error');
        }

        redirect('perfilUsuario/perfil');
    }
}