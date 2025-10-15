<?php
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo $titulo ?? 'Fashion Store - Tienda de Moda'; ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="<?php echo baseUrl('img/logo.png'); ?>" rel="icon">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

  <!-- Main CSS File -->
  <link href="<?php echo baseUrl('css/main.css'); ?>" rel="stylesheet">
  <link href="<?php echo baseUrl('css/landing.css'); ?>" rel="stylesheet">
  <link href="<?php echo baseUrl('css/carrito.css'); ?>" rel="stylesheet">
  <link href="<?php echo baseUrl('css/pedidos.css'); ?>" rel="stylesheet">
  <link href="<?php echo baseUrl('css/perfil.css'); ?>" rel="stylesheet">
</head>

<body class="index-page">

<!-- TOPBAR -->
<div class="site-topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="small text-muted d-none d-md-flex align-items-center">
            <i class="bi bi-telephone me-2"></i><span>+57 3113235370</span>
            <span class="mx-3">|</span>
            <i class="bi bi-clock me-2"></i><span>Lun-Sab 8:00 - 21:00</span>
        </div>

        <!-- AREA DEL PERFIL / LOGIN MEJORADA -->
        <div class="profile-section">
            <?php if (!empty($_SESSION['usuario_id'])): ?>
                <!-- Usuario autenticado: dropdown estilo "chip" mejorado -->
                <div class="dropdown">
                    <button class="btn profile-btn dropdown-toggle" id="perfilMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-avatar">
                            <?php echo strtoupper(htmlspecialchars(substr($_SESSION['usuario_nombre'] ?? 'U', 0, 1))); ?>
                        </div>
                        <div class="profile-info d-none d-sm-block">
                            <div class="profile-name"><?php echo htmlspecialchars($_SESSION['usuario_nombre'] ?? 'Usuario'); ?></div>
                            <div class="profile-email"><?php echo htmlspecialchars($_SESSION['usuario_correo'] ?? ''); ?></div>
                        </div>
                        <i class="bi bi-chevron-down small ms-1"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="perfilMenu">
                        <li>
                            <div class="dropdown-header small text-muted px-3 py-2">
                                Sesión activa
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="<?php echo baseUrl('perfilUsuario/perfil'); ?>">
                            <i class="bi bi-person"></i> Mi perfil
                        </a></li>
                        <li><a class="dropdown-item" href="<?php echo baseUrl('pedidosUsuario/mis_pedidos'); ?>">
                            <i class="bi bi-list-ul"></i> Mis pedidos
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?php echo baseUrl('logout'); ?>">
                            <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                        </a></li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- No autenticado - Botones mejorados -->
                <a href="<?php echo baseUrl('login'); ?>" class="btn btn-login me-2 d-none d-sm-inline-flex align-items-center">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    <span>Iniciar sesión</span>
                </a>
                <button class="btn btn-login d-inline-flex d-sm-none align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal" title="Iniciar sesión">
                    <i class="bi bi-box-arrow-in-right"></i>
                </button>

                <!-- Modal de login (mejorado visualmente) -->
                <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title text-center w-100" id="loginModalLabel">
                                    <i class="bi bi-box-arrow-in-right me-2 text-primary"></i> 
                                    Iniciar sesión
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body pt-0">
                                <form action="<?php echo baseUrl('login'); ?>" method="post" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="correo_modal" class="form-label small text-muted">Correo electrónico</label>
                                        <input type="email" class="form-control form-control-lg" id="correo_modal" name="correo" required placeholder="tu@email.com">
                                        <div class="invalid-feedback">Por favor ingresa un correo válido</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="clave_modal" class="form-label small text-muted">Contraseña</label>
                                        <input type="password" class="form-control form-control-lg" id="clave_modal" name="clave" required placeholder="••••••••">
                                        <div class="invalid-feedback">Ingresa tu contraseña</div>
                                    </div>
                                    <div class="small text-muted text-center mb-3">
                                        ¿No tienes cuenta? 
                                        <a href="<?php echo baseUrl('registro'); ?>" class="text-decoration-none">Regístrate aquí</a>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- HEADER PRINCIPAL / NAV -->
<header id="header" class="header">
    <div class="container header-main">
        <a href="<?php echo baseUrl(''); ?>" class="brand-logo">
            <img src="<?php echo baseUrl('img/logo.png'); ?>" alt="Fashion Store" class="logo-img">
            <div class="brand-text">
                <h1 class="sitename">Fashion Store</h1>
                <small class="tagline">Tienda de Moda</small>
            </div>
        </a>

        <nav class="navmenu d-none d-lg-block">
            <ul>
                <li><a href="<?php echo baseUrl(''); ?>" class="<?php echo (trim($_SERVER['REQUEST_URI'], '/') === '' ? 'active' : '') ?>">Inicio</a></li>
                <li><a href="#Informacion">Información</a></li>
                <li><a href="<?php echo baseUrl('catalogo#Catalogo'); ?>">Catálogo</a></li>
                <li><a href="#Ofertas">Ofertas</a></li>
                <li><a href="#Equipodetrabajo">Equipo</a></li>
                <li><a href="#Contacto">Contacto</a></li>
                <!-- Botón Carrito en el nav -->
                <li>
                    <button class="nav-link carrito-btn position-relative" id="btn-carrito">
                        <i class="bi bi-cart3"></i>
                        <span class="carrito-contador" id="carrito-contador" style="display: none;">0</span>
                    </button>
                </li>
            </ul>
        </nav>

        <!-- Mobile toggle -->
        <div class="d-lg-none d-flex align-items-center gap-2">
            <button class="btn carrito-btn position-relative" id="btn-carrito-mobile">
                <i class="bi bi-cart3"></i>
                <span class="carrito-contador" id="carrito-contador-mobile" style="display: none;">0</span>
            </button>
            <button class="btn mobile-nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mobileMenu">
                <i class="bi bi-list"></i>
            </button>
        </div>
    </div>

    <!-- Mobile menu collapse -->
    <div class="collapse" id="mobileMenu">
        <div class="container">
            <nav class="py-3">
                <ul class="list-unstyled">
                    <li><a href="<?php echo baseUrl(''); ?>">Inicio</a></li>
                    <li><a href="#Informacion">Información</a></li>
                    <li><a href="<?php echo baseUrl('catalogo'); ?>">Catálogo</a></li>
                    <li><a href="#Ofertas">Ofertas</a></li>
                    <li><a href="#Equipodetrabajo">Equipo</a></li>
                    <li><a href="#Contacto">Contacto</a></li>
                    <?php if (empty($_SESSION['usuario_id'])): ?>
                        <li><a href="<?php echo baseUrl('login'); ?>">Iniciar sesión</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo baseUrl('perfilUsuario/perfil'); ?>">Mi perfil</a></li>
                        <li><a href="<?php echo baseUrl('pedidosUsuario/mis_pedidos'); ?>">Mis pedidos</a></li>
                        <li><a href="<?php echo baseUrl('logout'); ?>">Cerrar sesión</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Panel del Carrito -->
    <div class="carrito-overlay" id="carrito-overlay"></div>
    <div class="carrito-sidebar" id="carrito-panel">
        <!-- El contenido se carga via AJAX -->
    </div>
</header>

<main class="mt-4 pt-3">
    <div class="container">
        <?php mostrarMensaje(); ?>

<script>
    // Definir baseUrl para JavaScript
    const baseUrl = '<?php echo baseUrl(''); ?>';
</script>