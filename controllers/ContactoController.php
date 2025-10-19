<?php
require_once __DIR__ . '/../models/Contacto.php';
require_once __DIR__ . '/../helpers/functions.php';

class ContactoController {
    private $contactoModel;
    
    public function __construct() {
        $this->contactoModel = new Contacto();
    }
    
    /**
     * Mostrar formulario de contacto
     */
    public function index() {
        $titulo = 'Contacto';
        require_once __DIR__ . '/../views/usuario/layout/header.php';
        require_once __DIR__ . '/../views/usuario/home/landing.php';
        require_once __DIR__ . '/../views/usuario/layout/footer.php';
    }
    
    /**
     * Procesar formulario de contacto (solo usuarios registrados)
     */
    public function enviarMensaje() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            setMensaje('Método no permitido', 'error');
            redirect('');
        }
        
        // Verificar que el usuario está logueado
        if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
            setMensaje('Debes iniciar sesión para enviar un mensaje', 'error');
            redirect('auth/login');
        }
        
        // Validar token CSRF si lo tienes implementado
        if (function_exists('verificarTokenCSRF') && isset($_POST['csrf_token']) && !verificarTokenCSRF($_POST['csrf_token'])) {
            setMensaje('Token de seguridad inválido', 'error');
            redirect('');
        }
        
        // Limpiar y validar datos
        $nombre = limpiarInput($_POST['name'] ?? '');
        $correo = limpiarInput($_POST['email'] ?? '');
        $asunto = limpiarInput($_POST['Asunto'] ?? '');
        $mensaje = limpiarInput($_POST['Mensaje'] ?? '');
        
        // Validaciones básicas
        if (empty($nombre) || empty($correo) || empty($asunto) || empty($mensaje)) {
            setMensaje('Por favor completa todos los campos', 'error');
            redirect('');
        }
        
        if (!esEmailValido($correo)) {
            setMensaje('El correo electrónico no es válido', 'error');
            redirect('');
        }
        
        if (strlen($mensaje) < 10) {
            setMensaje('El mensaje debe tener al menos 10 caracteres', 'error');
            redirect('');
        }
        
        if (strlen($nombre) < 2) {
            setMensaje('El nombre debe tener al menos 2 caracteres', 'error');
            redirect('');
        }
        
        if (strlen($asunto) < 5) {
            setMensaje('El asunto debe tener al menos 5 caracteres', 'error');
            redirect('');
        }
        
        // Asignar datos al modelo (incluyendo el usuario_id)
        $this->contactoModel->nombre = $nombre;
        $this->contactoModel->correo = $correo;
        $this->contactoModel->asunto = $asunto;
        $this->contactoModel->mensaje = $mensaje;
        $this->contactoModel->usuario_id = $_SESSION['usuario_id'];
        
        // Guardar en base de datos
        $resultado = $this->contactoModel->crear();
        
        if ($resultado['success']) {
            // Opcional: Enviar email de notificación
            $this->enviarEmailNotificacion($nombre, $correo, $asunto, $mensaje);
            
            setMensaje('¡Mensaje enviado exitosamente! Te contactaremos pronto.', 'success');
        } else {
            setMensaje('Error al enviar el mensaje. Por favor intenta nuevamente.', 'error');
        }
        
        redirect('');
    }
    
    /**
     * Enviar email de notificación (opcional)
     */
    private function enviarEmailNotificacion($nombre, $correo, $asunto, $mensaje) {
        // Configurar estos datos según tu servidor de correo
        $para = "Fashion31store@gmail.com";
        $titulo = "Nuevo mensaje de contacto: " . $asunto;
        
        $cuerpo = "
        <html>
        <head>
            <title>Nuevo mensaje de contacto</title>
            <style>
                body { font-family: Arial, sans-serif; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #007bff; color: white; padding: 15px; border-radius: 5px 5px 0 0; }
                .content { background: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px; }
                .field { margin-bottom: 10px; }
                .label { font-weight: bold; color: #495057; }
                .user-badge { background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Nuevo mensaje de contacto</h2>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='user-badge'>Usuario Registrado</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Nombre:</span> $nombre
                    </div>
                    <div class='field'>
                        <span class='label'>Correo:</span> <a href='mailto:$correo'>$correo</a>
                    </div>
                    <div class='field'>
                        <span class='label'>Asunto:</span> $asunto
                    </div>
                    <div class='field'>
                        <span class='label'>Mensaje:</span>
                        <div style='background: white; padding: 15px; border-radius: 5px; margin-top: 5px;'>
                            $mensaje
                        </div>
                    </div>
                    <br>
                    <p><em>Este mensaje fue enviado desde el formulario de contacto de Fashion Store por un usuario registrado.</em></p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Cabeceras para email HTML
        $cabeceras = "MIME-Version: 1.0" . "\r\n";
        $cabeceras .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $cabeceras .= "From: Fashion Store <no-reply@fashionstore.com>" . "\r\n";
        $cabeceras .= "Reply-To: $correo" . "\r\n";
        
        // Enviar email
        @mail($para, $titulo, $cuerpo, $cabeceras);
    }
}

// Para uso en el área de administración
class AdminContactoController {
    private $contactoModel;
    
    public function __construct() {
        requiereRol('admin');
        $this->contactoModel = new Contacto();
    }
    
    /**
     * Listar mensajes de contacto (admin)
     */
    public function index() {
        $q = isset($_GET['q']) ? trim($_GET['q']) : '';
        $filtro = $_GET['filtro'] ?? '';
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        // Obtener mensajes según búsqueda
        $mensajes = $this->contactoModel->obtenerTodosConBusqueda($q, $limit, $offset);
        $totalMensajes = $this->contactoModel->contarTodos($q);
        $totalNoLeidos = $this->contactoModel->contarNoLeidos();
        
        // Aplicar filtro de no leídos si está activo
        if ($filtro === 'no-leidos' && empty($q)) {
            $mensajes = array_filter($mensajes, function($mensaje) {
                return !$mensaje['leido'];
            });
            $totalMensajes = $this->contactoModel->contarPorEstado(0);
        } elseif ($filtro === 'no-leidos' && !empty($q)) {
            // Si hay búsqueda y filtro, aplicar filtro manualmente
            $mensajes = array_filter($mensajes, function($mensaje) {
                return !$mensaje['leido'];
            });
            $totalMensajes = count($mensajes);
        }
        
        $totalPaginas = ceil($totalMensajes / $limit);
        
        $titulo = 'Mensajes de Contacto';
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/contacto/index.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }
    
    /**
     * Ver mensaje individual
     */
    public function ver($id) {
        $mensaje = $this->contactoModel->obtenerPorId($id);
        
        if (!$mensaje) {
            setMensaje('Mensaje no encontrado', 'error');
            redirect('admin/contacto');
        }
        
        // Marcar como leído si no lo está
        if (!$mensaje['leido']) {
            $this->contactoModel->marcarLeido($id);
            $mensaje['leido'] = 1;
        }
        
        $titulo = 'Ver Mensaje - ' . $mensaje['asunto'];
        require_once __DIR__ . '/../views/admin/layout/header.php';
        require_once __DIR__ . '/../views/admin/contacto/ver.php';
        require_once __DIR__ . '/../views/admin/layout/footer.php';
    }
    
    /**
     * Eliminar mensaje
     */
    public function eliminar($id) {
        $mensaje = $this->contactoModel->obtenerPorId($id);
        
        if (!$mensaje) {
            setMensaje('Mensaje no encontrado', 'error');
            redirect('admin/contacto');
        }
        
        $resultado = $this->contactoModel->eliminar($id);
        
        if ($resultado) {
            setMensaje('Mensaje eliminado exitosamente', 'success');
        } else {
            setMensaje('Error al eliminar el mensaje', 'error');
        }
        
        redirect('admin/contacto');
    }
    
    /**
     * Marcar mensaje como leído (acción rápida)
     */
    public function marcarLeido($id) {
        $mensaje = $this->contactoModel->obtenerPorId($id);
        
        if (!$mensaje) {
            setMensaje('Mensaje no encontrado', 'error');
            redirect('admin/contacto');
        }
        
        $resultado = $this->contactoModel->marcarLeido($id);
        
        if ($resultado) {
            setMensaje('Mensaje marcado como leído', 'success');
        } else {
            setMensaje('Error al marcar el mensaje como leído', 'error');
        }
        
        redirect('admin/contacto');
    }
    
    /**
     * Obtener estadísticas para el dashboard
     */
    public function obtenerEstadisticas() {
        return [
            'totalMensajes' => $this->contactoModel->contarTodos(),
            'mensajesNoLeidos' => $this->contactoModel->contarNoLeidos(),
            'mensajesUsuariosRegistrados' => $this->contactoModel->contarPorTipoUsuario(true),
            'mensajesUsuariosNoRegistrados' => $this->contactoModel->contarPorTipoUsuario(false),
            'ultimosMensajes' => $this->contactoModel->obtenerNoLeidos(5)
        ];
    }
}
?>