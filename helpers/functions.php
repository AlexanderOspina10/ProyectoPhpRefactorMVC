<?php
/**
 * Funciones auxiliares globales
 */

/**
 * Validar si el usuario está autenticado
 */
function estaAutenticado() {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

/**
 * Obtener la URL base de la aplicación
 */
function obtenerBaseUrl() {
    $protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];

    // Directorio donde está el front controller (p. ej. /fashion_store/public)
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $scriptDir = rtrim($scriptDir, '/');

    $path = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;

    return $protocolo . '://' . $host . $path . '/';
}

/**
 * Generar una URL relativa (base + ruta)
 */
function baseUrl($ruta = '') {
    $ruta = ltrim($ruta, '/');
    $base = rtrim(obtenerBaseUrl(), '/');
    if ($ruta === '') {
        return $base . '/';
    }
    return $base . '/' . $ruta;
}

/**
 * Redirigir a una ruta específica
 */
function redirect($ruta = '') {
    // Aceptar URLs absolutas
    if (preg_match('#^https?://#i', $ruta)) {
        header("Location: $ruta");
        exit;
    }

    $ruta = ltrim($ruta, '/');

    if ($ruta === '') {
        $url = obtenerBaseUrl();
    } else {
        $url = rtrim(obtenerBaseUrl(), '/') . '/' . $ruta;
    }

    header("Location: " . $url);
    exit;
}

/**
 * Limpiar entrada para prevenir XSS
 */
function limpiarInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

/**
 * Escapar para HTML
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Establecer un mensaje en sesión
 */
function setMensaje($mensaje, $tipo = 'info') {
    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo_mensaje'] = $tipo; // success, error, warning, info
}

/**
 * Mostrar mensaje desde sesión
 */
function mostrarMensaje() {
    if (isset($_SESSION['mensaje']) && !empty($_SESSION['mensaje'])) {
        $tipo = $_SESSION['tipo_mensaje'] ?? 'info';
        $claseBT = '';

        switch ($tipo) {
            case 'success':
                $claseBT = 'alert-success';
                break;
            case 'error':
                $claseBT = 'alert-danger';
                break;
            case 'warning':
                $claseBT = 'alert-warning';
                break;
            default:
                $claseBT = 'alert-info';
        }

        echo '<div class="alert ' . $claseBT . ' alert-dismissible fade show" role="alert">';
        echo e($_SESSION['mensaje']);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';

        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    }
}

/**
 * Requerir que el usuario esté autenticado
 */
function requiereAutenticacion() {
    if (!estaAutenticado()) {
        setMensaje('Debes iniciar sesión primero', 'warning');
        redirect('login');
    }
}

/**
 * Requerir un rol específico
 */
function requiereRol($rolesPermitidos) {
    requiereAutenticacion();

    $rolesPermitidos = is_array($rolesPermitidos) ? $rolesPermitidos : [$rolesPermitidos];
    $rolUsuario = $_SESSION['usuario_rol'] ?? '';

    if (!in_array($rolUsuario, $rolesPermitidos)) {
        setMensaje('No tienes permiso para acceder a esta sección', 'error');
        redirect('login');
    }
}

/**
 * Validar formato de email
 */
function esEmailValido($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validar teléfono (formato básico)
 */
function esTelefonoValido($telefono) {
    return preg_match('/^[0-9]{7,15}$/', $telefono);
}

/**
 * Generar un token CSRF
 */
function generarTokenCSRF() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verificar token CSRF
 */
function verificarTokenCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Mostrar campo de token CSRF en formularios
 */
function campoTokenCSRF() {
    echo '<input type="hidden" name="csrf_token" value="' . generarTokenCSRF() . '">';
}
?>
