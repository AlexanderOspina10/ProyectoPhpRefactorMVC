<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="<?php echo baseUrl('img/logo.png'); ?>" rel="icon">
    <title>Iniciar Sesión - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="<?php echo baseUrl('css/auth.css'); ?>" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="container">
        <div class="auth-container">
            
            <div class="card auth-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="auth-header">
                        <div class="logo-container">
                            <img src="<?php echo baseUrl('img/logo.png'); ?>" alt="Fashion Store" class="logo-img">
                        </div>
                        <h1 class="auth-title">Fashion Store</h1>
                        <p class="auth-subtitle">Bienvenido de nuevo</p>
                    </div>
                    
                    <?php mostrarMensaje(); ?>
                    
                    <form action="<?= baseUrl('login') ?>" method="post" class="mt-4">
                        <div class="mb-4">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input type="email" class="form-control" id="correo" name="correo" required 
                                       placeholder="tu.email@ejemplo.com">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="clave" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control" id="clave" name="clave" required 
                                       placeholder="Ingresa tu contraseña">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-4">
                            <i class="bi bi-box-arrow-in-right me-2"></i> 
                            Iniciar Sesión
                        </button>
                        
                        <div class="text-center pt-3 border-top">
                            <p class="text-muted mb-0">
                                ¿No tienes cuenta? 
                                <a href="<?= baseUrl('registro') ?>" class="fw-bold">
                                    Regístrate aquí
                                </a>
                            </p>
                        </div>
                        <br>
                         <div class="text-center mb-4">
                            <a href="<?php echo baseUrl(''); ?>" class="btn btn-primary w-100 mb-4">
                                <i class="bi bi-arrow-left me-2"></i> 
                                <span>Volver a la Tienda</span>
                            </a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>