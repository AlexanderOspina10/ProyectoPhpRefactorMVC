<?php
/**
 * Configuración de la base de datos
 * Conexión a MySQL usando mysqli
 */

$host = "localhost";
$user = "root";
$pass = "3135497455Jj";
$db = "fashion_store";

// Crear conexión
$con = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($con->connect_errno) {
    die("Error en la conexión: " . $con->connect_error);
}

// Configurar charset
$con->set_charset("utf8mb4");

// Definir constantes de base de datos
define('DB_HOST', $host);
define('DB_USER', $user);
define('DB_PASS', $pass);
define('DB_NAME', $db);
?>