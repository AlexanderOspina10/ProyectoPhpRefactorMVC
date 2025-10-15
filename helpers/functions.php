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
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $scriptDir = rtrim($scriptDir, '/');
    $path = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    return $protocolo . '://' . $host . $path . '/';
}

/**
 * Generar una URL relativa
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
 * Redirigir a una ruta
 */
function redirect($ruta = '') {
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

/**
 * Subir y validar una imagen desde $_FILES
 */
function subirImagen($file, $subfolder = 'uploads/products', $maxSizeBytes = 2097152) {
    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'filename' => null, 'message' => 'No se subió ninguna imagen'];
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'filename' => null, 'message' => 'Error al subir la imagen'];
    }

    if ($file['size'] > $maxSizeBytes) {
        return ['success' => false, 'filename' => null, 'message' => 'La imagen es demasiado grande (máx 2MB)'];
    }

    $allowedMime = ['image/jpeg' => 'jpg', 'image/jpg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!isset($allowedMime[$mime])) {
        return ['success' => false, 'filename' => null, 'message' => 'Formato de imagen no permitido. Usa JPG, PNG o WEBP'];
    }

    $publicPath = rtrim(__DIR__ . '/../public', '/\\') . '/';
    $destFolder = $publicPath . trim($subfolder, '/\\') . '/';

    if (!is_dir($destFolder)) {
        if (!mkdir($destFolder, 0755, true)) {
            return ['success' => false, 'filename' => null, 'message' => 'No se pudo crear carpeta para imágenes'];
        }
    }

    $ext = $allowedMime[$mime];
    $basename = bin2hex(random_bytes(8)) . '_' . time();
    $filename = $basename . '.' . $ext;
    $destPath = $destFolder . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        return ['success' => false, 'filename' => null, 'message' => 'No se pudo guardar la imagen en el servidor'];
    }

    $relative = trim($subfolder, '/\\') . '/' . $filename;
    return ['success' => true, 'filename' => $relative, 'message' => 'Imagen subida correctamente'];
}

/**
 * Formato de moneda colombiana
 */
function formatearPrecio($precio) {
    return '$' . number_format($precio, 0, ',', '.');
}

/**
 * Obtener nombre del rol con mayúscula
 */
function nombreRol($rol) {
    $roles = [
        'admin' => 'Administrador',
        'vendedor' => 'Vendedor',
        'cliente' => 'Cliente',
        'usuario' => 'Usuario'
    ];
    return $roles[$rol] ?? ucfirst($rol);
}

/**
 * Validar rango de fechas
 */
function esRangoFechaValido($fecha_inicio, $fecha_fin) {
    try {
        $inicio = new DateTime($fecha_inicio);
        $fin = new DateTime($fecha_fin);
        return $inicio <= $fin;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Obtener diferencia en días entre dos fechas
 */
function diasEntre($fecha1, $fecha2) {
    try {
        $f1 = new DateTime($fecha1);
        $f2 = new DateTime($fecha2);
        $diff = $f1->diff($f2);
        return $diff->days;
    } catch (Exception $e) {
        return 0;
    }
}

/**
 * Formatear fecha en formato simple (solo fecha, sin hora)
 */
function fechaFormatoHumano($fecha) {
    $timestamp = strtotime($fecha);
    
    // Si es hoy
    if (date('Y-m-d', $timestamp) === date('Y-m-d')) {
        return 'Hoy';
    }
    
    // Si fue ayer
    if (date('Y-m-d', $timestamp) === date('Y-m-d', strtotime('-1 day'))) {
        return 'Ayer';
    }
    
    // Para cualquier otra fecha, mostrar fecha completa
    return date('d/m/Y', $timestamp); // Formato: 15/03/2024
}

/**
 * Formatear fecha completa (solo fecha, sin hora)
 */
function fechaFormatoCompleto($fecha) {
    $timestamp = strtotime($fecha);
    
    // Nombres de meses en español
    $meses = [
        1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril',
        5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto',
        9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'
    ];
    
    $dia = date('d', $timestamp);
    $mes = $meses[date('n', $timestamp)];
    $anio = date('Y', $timestamp);
    
    return $dia . ' de ' . $mes . ' de ' . $anio; // Ej: "15 de marzo de 2024"
}

/**
 * Obtener color Bootstrap según estado del pedido
 */
function obtenerColorEstado($estado) {
    switch ($estado) {
        case 'pendiente':
            return 'warning';
        case 'procesando':
            return 'info';
        case 'enviado':
            return 'primary';
        case 'completado':
            return 'success';
        case 'cancelado':
            return 'danger';
        default:
            return 'secondary';
    }
}

/**
 * Obtener nombre del estado del pedido en español
 */
function nombreEstadoPedido($estado) {
    $estados = [
        'pendiente' => 'Pendiente',
        'procesando' => 'Procesando',
        'enviado' => 'Enviado',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado'
    ];
    return $estados[$estado] ?? ucfirst($estado);
}

/**
 * Validar que una fecha sea válida
 */
function esFechaValida($fecha, $formato = 'Y-m-d H:i:s') {
    $d = DateTime::createFromFormat($formato, $fecha);
    return $d && $d->format($formato) === $fecha;
}

/**
 * Formatear número con separadores de miles
 */
function formatearNumero($numero, $decimales = 0) {
    return number_format($numero, $decimales, ',', '.');
}

/**
 * Acortar texto a una longitud específica
 */
function acortarTexto($texto, $longitud = 100, $sufijo = '...') {
    if (strlen($texto) <= $longitud) {
        return $texto;
    }
    return substr($texto, 0, $longitud) . $sufijo;
}

/**
 * Generar un código aleatorio
 */
function generarCodigo($longitud = 8) {
    $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

/**
 * Obtener la fecha actual en formato para base de datos
 */
function fechaActual() {
    return date('Y-m-d H:i:s');
}

/**
 * Obtener solo la fecha (sin hora) en formato para base de datos
 */
function fechaHoy() {
    return date('Y-m-d');
}
?>