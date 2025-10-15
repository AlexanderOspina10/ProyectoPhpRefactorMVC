<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-envelope me-2"></i>Ver Mensaje</h2>
    <div>
        <a href="<?php echo baseUrl('admin/contacto'); ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="bi bi-chat-quote me-2"></i>
                    <?php echo e($mensaje['asunto']); ?>
                </h5>
            </div>
            <div class="card-body">
                <!-- Información del remitente -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted">Remitente</h6>
                        <p class="mb-1">
                            <i class="bi bi-person me-2"></i>
                            <strong><?php echo e($mensaje['nombre']); ?></strong>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:<?php echo e($mensaje['correo']); ?>">
                                <?php echo e($mensaje['correo']); ?>
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Información</h6>
                        <p class="mb-1">
                            <i class="bi bi-calendar me-2"></i>
                            <strong>Enviado:</strong> 
                            <?php echo fechaFormatoCompleto($mensaje['created_at']); ?>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-clock me-2"></i>
                            <strong>Hace:</strong> 
                            <?php echo fechaFormatoHumano($mensaje['created_at']); ?>
                        </p>
                    </div>
                </div>

                <hr>

                <!-- Contenido del mensaje -->
                <div class="mb-4">
                    <h6 class="text-muted mb-3">Mensaje</h6>
                    <div class="bg-light p-4 rounded">
                        <p class="mb-0" style="white-space: pre-wrap;"><?php echo e($mensaje['mensaje']); ?></p>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="d-flex gap-2">
                    <a href="mailto:<?php echo e($mensaje['correo']); ?>?subject=Re: <?php echo urlencode($mensaje['asunto']); ?>" 
                       class="btn btn-primary">
                        <i class="bi bi-reply me-1"></i> Responder
                    </a>
                    <a href="<?php echo baseUrl('admin/contacto/eliminar/' . $mensaje['id']); ?>" 
                       class="btn btn-outline-danger"
                       onclick="return confirm('¿Estás seguro de que quieres eliminar este mensaje?')">
                        <i class="bi bi-trash me-1"></i> Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Información adicional -->
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-info-circle me-2"></i> Información del Mensaje
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <span class="badge bg-<?php echo $mensaje['leido'] ? 'success' : 'warning'; ?>">
                        <?php echo $mensaje['leido'] ? 'Leído' : 'No leído'; ?>
                    </span>
                </div>
                
                <div class="small text-muted">
                    <p><strong>ID del mensaje:</strong> #<?php echo $mensaje['id']; ?></p>
                    <p><strong>Longitud del mensaje:</strong> <?php echo strlen($mensaje['mensaje']); ?> caracteres</p>
                    
                    <?php if ($mensaje['leido']): ?>
                        <p class="text-success">
                            <i class="bi bi-check-circle me-1"></i>
                            Marcado como leído automáticamente
                        </p>
                    <?php else: ?>
                        <p class="text-warning">
                            <i class="bi bi-exclamation-circle me-1"></i>
                            Mensaje nuevo sin leer
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="bi bi-lightning me-2"></i> Acciones Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="mailto:<?php echo e($mensaje['correo']); ?>" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-envelope me-1"></i> Enviar Email
                    </a>
                    <a href="<?php echo baseUrl('admin/contacto'); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-list me-1"></i> Ver Todos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>