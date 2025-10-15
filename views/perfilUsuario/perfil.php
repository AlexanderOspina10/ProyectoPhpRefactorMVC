<section class="perfil-usuario py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <h1 class="h2 mb-0 fw-bold">Mi Perfil</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Información del Perfil -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-person-circle me-2"></i>Información Personal
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo baseUrl('perfilUsuario/actualizar'); ?>" method="POST" id="form-perfil">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                           value="<?php echo htmlspecialchars($usuario['nombre']); ?>" 
                                           required placeholder="Tu nombre">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label fw-semibold">
                                        Apellido <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" 
                                           value="<?php echo htmlspecialchars($usuario['apellido']); ?>" 
                                           required placeholder="Tu apellido">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="correo" class="form-label fw-semibold">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" 
                                       value="<?php echo htmlspecialchars($usuario['correo']); ?>" 
                                       readonly disabled>
                                <div class="form-text text-muted">
                                    El correo electrónico no se puede modificar. Contacta al administrador si necesitas cambiarlo.
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">
                                        Teléfono <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           value="<?php echo htmlspecialchars($usuario['telefono']); ?>" 
                                           required placeholder="Ej: +57 300 123 4567">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label fw-semibold">Rol</label>
                                    <input type="text" class="form-control" id="rol" 
                                           value="<?php echo htmlspecialchars($usuario['rol_nombre']); ?>" 
                                           readonly disabled>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-semibold">
                                    Dirección <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="direccion" name="direccion" 
                                          rows="3" required placeholder="Tu dirección completa"><?php echo htmlspecialchars($usuario['direccion']); ?></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Miembro desde: <?php echo date('d/m/Y', strtotime($usuario['created_at'])); ?>
                                </small>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Cambio de Contraseña y Acciones -->
            <div class="col-lg-4">
                <!-- Cambio de Contraseña -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-warning text-dark py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-shield-lock me-2"></i>Cambiar Contraseña
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo baseUrl('perfilUsuario/cambiarClave'); ?>" method="POST" id="form-clave">
                            <div class="mb-3">
                                <label for="clave_actual" class="form-label fw-semibold">
                                    Contraseña Actual <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" id="clave_actual" name="clave_actual" 
                                       required placeholder="Ingresa tu contraseña actual">
                            </div>
                            
                            <div class="mb-3">
                                <label for="clave_nueva" class="form-label fw-semibold">
                                    Nueva Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" id="clave_nueva" name="clave_nueva" 
                                       required placeholder="Mínimo 6 caracteres">
                                <div class="form-text">La contraseña debe tener al menos 6 caracteres.</div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="clave_confirmar" class="form-label fw-semibold">
                                    Confirmar Contraseña <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" id="clave_confirmar" name="clave_confirmar" 
                                       required placeholder="Repite la nueva contraseña">
                            </div>
                            
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-key me-2"></i>Cambiar Contraseña
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Información de Seguridad -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-shield-check me-2"></i>Seguridad
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <div>
                                <small class="fw-semibold d-block">Cuenta Verificada</small>
                                <small class="text-muted">Estado: Activa</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-clock-history text-primary me-2"></i>
                            <div>
                                <small class="fw-semibold d-block">Última Actualización</small>
                                <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?></small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-badge text-secondary me-2"></i>
                            <div>
                                <small class="fw-semibold d-block">Tipo de Cuenta</small>
                                <small class="text-muted"><?php echo htmlspecialchars(ucfirst($usuario['rol_nombre'])); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación de contraseñas coincidentes
    const formClave = document.getElementById('form-clave');
    if (formClave) {
        formClave.addEventListener('submit', function(e) {
            const claveNueva = document.getElementById('clave_nueva').value;
            const claveConfirmar = document.getElementById('clave_confirmar').value;
            
            if (claveNueva !== claveConfirmar) {
                e.preventDefault();
                alert('❌ Las contraseñas no coinciden. Por favor verifica.');
                document.getElementById('clave_confirmar').focus();
            }
        });
    }
    
    // Validación de teléfono
    const telefonoInput = document.getElementById('telefono');
    if (telefonoInput) {
        telefonoInput.addEventListener('input', function(e) {
            // Permitir solo números, espacios, + y -
            this.value = this.value.replace(/[^\d+\-\s]/g, '');
        });
    }
});
</script>