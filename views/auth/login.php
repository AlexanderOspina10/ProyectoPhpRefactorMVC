<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fashion Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            max-width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-shop" style="font-size: 3rem; color: #667eea;"></i>
                        <h2 class="mt-2">Fashion Store</h2>
                        <p class="text-muted">Inicia sesión en tu cuenta</p>
                    </div>
                    
                    <?php mostrarMensaje(); ?>
                    
                    <form action="<?= baseUrl('login') ?>" method="post">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="clave" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="clave" name="clave" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </button>
                        
                        <div class="text-center">
                            <small>¿No tienes cuenta? <a href="<?= baseUrl('registro') ?>">Registrarse</a></small>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>