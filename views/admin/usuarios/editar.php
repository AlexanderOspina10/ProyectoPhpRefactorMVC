
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Usuario</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo baseUrl('admin/usuarios/actualizar'); ?>" method="POST">
                    <?php campoTokenCSRF(); ?>
                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required 
                                   maxlength="25" value="<?php echo e($usuario['nombre']); ?>">
                            <small class="text-muted">Máximo 25 caracteres</small>
                        </div>
                        <div class="col-md-6">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required 
                                   maxlength="45" value="<?php echo e($usuario['apellido']); ?>">
                            <small class="text-muted">Máximo 45 caracteres</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo" name="correo" required 
                               value="<?php echo e($usuario['correo']); ?>">
                        <small class="text-muted">Debe ser único en el sistema</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required 
                               pattern="[0-9]{7,15}" value="<?php echo e($usuario['telefono']); ?>">
                        <small class="text-muted">Entre 7 y 15 dígitos</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required 
                               maxlength="50" value="<?php echo e($usuario['direccion']); ?>">
                        <small class="text-muted">Máximo 50 caracteres</small>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="rol_id" class="form-label">Rol</label>
                            <select class="form-select" id="rol_id" name="rol_id" required>
                                <?php foreach ($roles as $rol): ?>
                                    <option value="<?php echo $rol['id']; ?>" 
                                            <?php echo ($rol['id'] == $usuario['rol_id']) ? 'selected' : ''; ?>>
                                        <?php echo ucfirst(e($rol['nombre'])); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="activo" class="form-label">Estado</label>
                            <select class="form-select" id="activo" name="activo" required>
                                <option value="1" <?php echo ($usuario['activo'] == 1) ? 'selected' : ''; ?>>
                                    Activo
                                </option>
                                <option value="0" <?php echo ($usuario['activo'] == 0) ? 'selected' : ''; ?>>
                                    Inactivo
                                </option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning small mb-3">
                        <i class="bi bi-exclamation-triangle"></i> 
                        <strong>Nota:</strong> Para cambiar la contraseña, utiliza la opción de cambio de contraseña en tu perfil.
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-muted small mb-1">
                                <i class="bi bi-calendar"></i> 
                                <strong>Fecha de registro:</strong> 
                                <?php echo date('d/m/Y H:i', strtotime($usuario['created_at'])); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-secondary">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check"></i> Actualizar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
