
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus"></i> Crear Nuevo Usuario</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo baseUrl('admin/usuarios/guardar'); ?>" method="POST">
                    <?php campoTokenCSRF(); ?>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required 
                                   maxlength="25" placeholder="Juan">
                            <small class="text-muted">Máximo 25 caracteres</small>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required 
                                   maxlength="45" placeholder="Pérez">
                            <small class="text-muted">Máximo 45 caracteres</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required 
                               placeholder="usuario@ejemplo.com">
                        <small class="text-muted">Debe ser único en el sistema</small>
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
                        <small class="text-muted">Máximo 50 caracteres</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="rol_id" class="form-label">Rol</label>
                        <select class="form-select" id="rol_id" name="rol_id" required>
                            <option value="">Selecciona un rol</option>
                            <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>">
                                    <?php echo ucfirst(e($rol['nombre'])); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" required 
                               minlength="6" placeholder="Mínimo 6 caracteres">
                        <small class="text-muted">Mínimo 6 caracteres. Se guardará de forma segura</small>
                    </div>
                    
                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle"></i> 
                        La contraseña será hasheada de forma segura. Se recomienda usar una contraseña fuerte.
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Crear Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
