<?php
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';

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

        // Normalizar directorio del script (ej: /fashion_store/public)
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        if ($scriptDir !== '/' && $scriptDir !== '\\') {
            if (strpos($requestUri, $scriptDir) === 0) {
                $requestUri = substr($requestUri, strlen($scriptDir));
            }
        }

        // Limpiar slashes al inicio/final
        $requestUri = trim($requestUri, '/');

        // Si no hay rutas para el método => 405
        if (!isset($this->routes[$requestMethod])) {
            http_response_code(405);
            echo "<h1>405 - Método no permitido</h1>";
            exit;
        }

        // Coincidencia exacta incluyendo ruta raíz ('')
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

        // Rutas con parámetros (p.ej. admin/usuarios/editar/{id})
        foreach ($this->routes[$requestMethod] as $uri => $route) {
            $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $uri);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches);
                $controller = new $route['controller']();
                return call_user_func_array([$controller, $route['method']], $matches);
            }
        }

        // Ruta no encontrada
        http_response_code(404);
        echo "<h1>404 - Página no encontrada</h1>";
        exit;
    }
}

// Crear instancia del router
$router = new Router();

// Rutas de autenticación
$router->get('', 'AuthController', 'mostrarLogin');
$router->get('login', 'AuthController', 'mostrarLogin');
$router->post('login', 'AuthController', 'login');
$router->get('registro', 'AuthController', 'mostrarRegistro');
$router->post('registro', 'AuthController', 'registro');
$router->get('logout', 'AuthController', 'logout');
$router->get('force-logout', 'AuthController', 'forceLogout');

// Rutas de administración de usuarios
$router->get('admin/usuarios', 'UsuarioController', 'index');
$router->get('admin/usuarios/crear', 'UsuarioController', 'crear');
$router->post('admin/usuarios/guardar', 'UsuarioController', 'guardar');
$router->get('admin/usuarios/editar/{id}', 'UsuarioController', 'editar');
$router->post('admin/usuarios/actualizar', 'UsuarioController', 'actualizar');
$router->get('admin/usuarios/eliminar/{id}', 'UsuarioController', 'eliminar');

// Resolver la ruta
$router->resolve();
?>
