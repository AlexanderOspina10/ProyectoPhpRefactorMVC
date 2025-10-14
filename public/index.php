<?php
/**
 * Punto de entrada principal de la aplicación
 * Fashion Store - Sistema MVC
 */

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración de errores (desactivar en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cargar la conexión a la base de datos (debe definir $con)
require_once __DIR__ . '/../config/database.php';

// Depuración rápida opcional: confirma que $con existe (quita luego)
if (!isset($con) || !$con) {
    die("ERROR: La conexión \$con no está inicializada. Revisa config/database.php");
}

// Incluir funciones auxiliares
require_once __DIR__ . '/../helpers/functions.php';

// Cargar el sistema de rutas
require_once __DIR__ . '/../routes/web.php';
?>