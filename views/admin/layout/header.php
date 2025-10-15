<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- Favicons -->
    <link href="<?php echo baseUrl('img/logo.png'); ?>" rel="icon">
    <title><?php echo $titulo ?? 'Fashion Store - Admin'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo baseUrl('css/style.css'); ?>">

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo baseUrl('admin/dashboard'); ?>">
                <i class="bi bi-shop"></i> Fashion Store
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('admin/dashboard'); ?>">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('admin/usuarios'); ?>">
                            <i class="bi bi-people"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('admin/productos'); ?>">
                            <i class="bi bi-archive-fill"></i> Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('admin/pedidos'); ?>">
                            <i class="bi bi-card-checklist"></i> Pedidos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo baseUrl('admin/contacto'); ?>">
                            <i class="bi bi-envelope"></i> Mensajes
                            <?php 
                            // Mostrar badge si hay mensajes no leídos
                            if (isset($mensajesNoLeidos) && $mensajesNoLeidos > 0): 
                            ?>
                                <span class="badge bg-danger"><?php echo $mensajesNoLeidos; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?php echo e($_SESSION['usuario_nombre']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text"><small><?php echo e($_SESSION['usuario_correo']); ?></small></span></li>
                            <li><span class="dropdown-item-text"><small><strong>Rol:</strong> <?php echo ucfirst(e($_SESSION['usuario_rol'])); ?></small></span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo baseUrl('logout'); ?>">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Contenedor que crecerá para empujar el footer -->
    <div class="container mt-4 content">
        <?php mostrarMensaje(); ?>
