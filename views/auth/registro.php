<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="<?php echo baseUrl('img/logo.png'); ?>" rel="icon">
    <title>Crear Cuenta - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="<?php echo baseUrl('css/auth.css'); ?>" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="container">
        <div class="auth-container registro">
            
           
            
            <div class="card auth-card">
                <div class="card-body p-4 p-lg-5">
                    <div class="auth-header">
                        <div class="logo-container">
                            <img src="<?php echo baseUrl('img/logo.png'); ?>" alt="Fashion Store" class="logo-img">
                        </div>
                        <h1 class="auth-title">Fashion Store</h1>
                        <p class="auth-subtitle">Crea tu cuenta nueva</p>
                    </div>
                    
                    <?php mostrarMensaje(); ?>
                    
                    <form action="<?php echo baseUrl('registro'); ?>" method="POST" class="mt-4">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                       maxlength="25" placeholder="Juan">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required 
                                       maxlength="45" placeholder="Pérez">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-envelope-fill"></i>
                                </span>
                                <input type="email" class="form-control" id="correo" name="correo" required 
                                       placeholder="usuario@ejemplo.com">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required 
                                       pattern="[0-9]{7,15}" placeholder="300 123 4567">
                            </div>
                            <div class="form-text">Entre 7 y 15 dígitos</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </span>
                                <input type="text" class="form-control" id="direccion" name="direccion" required 
                                       maxlength="50" placeholder="Calle Principal #123">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="clave" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-shield-lock-fill"></i>
                                </span>
                                <input type="password" class="form-control" id="clave" name="clave" required 
                                       minlength="6" placeholder="Mínimo 6 caracteres">
                            </div>
                            <div class="form-text">Mínimo 6 caracteres</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-4">
                            <i class="bi bi-person-check-fill me-2"></i> 
                            Crear Cuenta
                        </button>
                        
                        <div class="text-center pt-3 border-top">
                            <p class="text-muted mb-0">
                                ¿Ya tienes cuenta? 
                                <a href="<?php echo baseUrl('login'); ?>" class="fw-bold">
                                    Inicia sesión aquí
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