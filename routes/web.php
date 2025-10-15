<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/../controllers/ProductoController.php';
require_once __DIR__ . '/../controllers/PedidoController.php';
require_once __DIR__ . '/../controllers/DashboardController.php';
require_once __DIR__ . '/../controllers/PublicProductoController.php';
require_once __DIR__ . '/../controllers/PedidosUsuarioController.php';
require_once __DIR__ . '/../controllers/PerfilUsuarioController.php';
require_once __DIR__ . '/../controllers/ContactoController.php';
require_once __DIR__ . '/../controllers/CarritoController.php';

/**
 * Sistema de enrutamiento simple
 */
class Router {
    private $routes = [];

    public function get($uri, $controller, $method) {
        $this->routes['GET'][$uri] = ['controller' => $controller, 'method' => $method];
    }

    public function post($uri, $controller, $method) {
        $this->routes['POST'][$uri] = ['controller' => $controller, 'method' => $method];
    }

    public function resolve() {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Normalizar directorio del script
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir !== '/' && $scriptDir !== '\\') {
            if (strpos($requestUri, $scriptDir) === 0) {
                $requestUri = substr($requestUri, strlen($scriptDir));
            }
        }

        $requestUri = trim($requestUri, '/');

        if (!isset($this->routes[$requestMethod])) {
            http_response_code(405);
            echo "<h1>405 - Método no permitido</h1>";
            exit;
        }

        // Coincidencia exacta
        if ($requestUri === '' && isset($this->routes[$requestMethod][''])) {
            $route = $this->routes[$requestMethod][''];
            $controller = new $route['controller']();
            return call_user_func([$controller, $route['method']]);
        }

        if (isset($this->routes[$requestMethod][$requestUri])) {
            $route = $this->routes[$requestMethod][$requestUri];
            $controller = new $route['controller']();
            return call_user_func([$controller, $route['method']]);
        }

        // Rutas con parámetros
        foreach ($this->routes[$requestMethod] as $uri => $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                $controller = new $route['controller']();
                return call_user_func_array([$controller, $route['method']], $matches);
            }
        }

        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        exit;
    }
}

// Instancia del router
$router = new Router();

// ============================================
// RUTAS DE AUTENTICACIÓN
// ============================================
$router->get('', 'AuthController', 'mostrarLogin');
$router->get('login', 'AuthController', 'mostrarLogin');
$router->post('login', 'AuthController', 'login');
$router->get('registro', 'AuthController', 'mostrarRegistro');
$router->post('registro', 'AuthController', 'registro');
$router->get('logout', 'AuthController', 'logout');
$router->get('force-logout', 'AuthController', 'forceLogout');

// ============================================
// RUTAS DEL ADMIN
// ============================================

// Dashboard - AGREGAR AMBAS RUTAS
$router->get('admin', 'DashboardController', 'index');
$router->get('admin/dashboard', 'DashboardController', 'index'); // Agregar esta línea

// Usuarios
$router->get('admin/usuarios', 'UsuarioController', 'index');
$router->get('admin/usuarios/crear', 'UsuarioController', 'crear');
$router->post('admin/usuarios/guardar', 'UsuarioController', 'guardar');
$router->get('admin/usuarios/editar/{id}', 'UsuarioController', 'editar');
$router->post('admin/usuarios/actualizar', 'UsuarioController', 'actualizar');
$router->get('admin/usuarios/eliminar/{id}', 'UsuarioController', 'eliminar');

// Productos
$router->get('admin/productos', 'ProductoController', 'index');
$router->get('admin/productos/crear', 'ProductoController', 'crear');
$router->post('admin/productos/guardar', 'ProductoController', 'guardar');
$router->get('admin/productos/editar/{id}', 'ProductoController', 'editar');
$router->post('admin/productos/actualizar', 'ProductoController', 'actualizar');
$router->get('admin/productos/eliminar/{id}', 'ProductoController', 'eliminar');

// Pedidos
$router->get('admin/pedidos', 'PedidoController', 'index');
$router->get('admin/pedidos/ver/{id}', 'PedidoController', 'ver');
$router->post('admin/pedidos/actualizarEstado', 'PedidoController', 'actualizarEstado');
$router->get('admin/pedidos/eliminar/{id}', 'PedidoController', 'eliminar');

// ============================================
// RUTAS DEL USUARIO (Lado público)
// ============================================

// RUTAS PÚBLICAS / USUARIO (lado público)
$router->get('', 'PublicProductoController', 'landing'); // raíz -> landing
$router->get('catalogo', 'PublicProductoController', 'landing'); // alternativa
$router->get('producto/ver/{id}', 'PublicProductoController', 'ver'); // detalle (opcional)

// ============================================
// RUTAS DEL CARRITO (CORREGIDAS)
// ============================================

// Carrito
$router->post('carrito/agregar/{id}', 'CarritoController', 'agregar');
$router->post('carrito/actualizar/{id}', 'CarritoController', 'actualizar');
$router->get('carrito/eliminar/{id}', 'CarritoController', 'eliminar');
$router->get('carrito/vaciar', 'CarritoController', 'vaciar');
$router->get('carrito/mostrarPanel', 'CarritoController', 'mostrarPanel');
$router->get('carrito/finalizar', 'CarritoController', 'finalizar');

// Pedidos de Usuario
$router->get('pedidosUsuario/finalizar', 'PedidosUsuarioController', 'finalizar');
$router->post('pedidosUsuario/procesar', 'PedidosUsuarioController', 'procesar');
$router->get('pedidosUsuario/mis_pedidos', 'PedidosUsuarioController', 'mis_pedidos');
$router->get('pedidosUsuario/ver/{id}', 'PedidosUsuarioController', 'ver');

// Perfil de Usuario
$router->get('perfilUsuario/perfil', 'PerfilUsuarioController', 'perfil');
$router->post('perfilUsuario/actualizar', 'PerfilUsuarioController', 'actualizar');
$router->post('perfilUsuario/cambiarClave', 'PerfilUsuarioController', 'cambiarClave');

// ============================================
// RUTAS DE CONTACTO (CORREGIDAS)
// ============================================

// Rutas de contacto público
$router->get('contacto', 'ContactoController', 'index');
$router->post('contacto/enviar', 'ContactoController', 'enviarMensaje');

// Rutas de administración para mensajes de contacto
$router->get('admin/contacto', 'AdminContactoController', 'index');
$router->get('admin/contacto/ver/{id}', 'AdminContactoController', 'ver');
$router->get('admin/contacto/eliminar/{id}', 'AdminContactoController', 'eliminar');
$router->get('admin/contacto/marcar-leido/{id}', 'AdminContactoController', 'marcarLeido');

// Resolver la ruta
$router->resolve();
?>