<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .registro-card {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="registro-card">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shop" style="font-size: 3rem; color: #667eea;"></i>
                        <h2 class="mt-2">Fashion Store</h2>
                        <p class="text-muted">Crear nueva cuenta</p>
                    </div>
                    
                    <?php mostrarMensaje(); ?>
                    
                    <form action="<?php echo baseUrl('registro'); ?>" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                       maxlength="25" placeholder="Juan">
                            </div>
                            <div class="col-md-6">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required 
                                       maxlength="45" placeholder="Pérez">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" required 
                                       placeholder="usuario@ejemplo.com">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required 
                                   pattern="[0-9]{7,15}" placeholder="3001234567">
                            <small class="text-muted">Entre 7 y 15 dígitos</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required 
                                   maxlength="50" placeholder="Calle Principal 123">
                        </div>
                        
                        <div class="mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="clave" name="clave" required 
                                       minlength="6" placeholder="Mínimo 6 caracteres">
                            </div>
                            <small class="text-muted">Mínimo 6 caracteres</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-person-check"></i> Registrarse
                        </button>
                        
                        <div class="text-center">
                            <small>¿Ya tienes cuenta? <a href="<?php echo baseUrl('login'); ?>">Inicia sesión aquí</a></small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>