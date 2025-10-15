<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h2>
        <p class="text-muted mb-0">Resumen general del sistema Fashion Store</p>
    </div>
    <div class="text-end">
        <small class="text-muted">Actualizado: <?php echo date('d/m/Y H:i'); ?></small>
    </div>
</div>

<!-- Estadísticas Principales - Diseño Mejorado -->
<div class="row mb-5">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start-primary border-start-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">Usuarios Registrados</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $totalUsuarios; ?></div>
                        <div class="mt-2">
                            <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-arrow-right me-1"></i>Gestionar
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people-fill fa-2x text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start-success border-start-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">Productos en Stock</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $totalProductos; ?></div>
                        <div class="mt-2">
                            <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-arrow-right me-1"></i>Gestionar
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-box-seam fa-2x text-success opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start-warning border-start-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">Total de Pedidos</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $totalPedidos; ?></div>
                        <div class="mt-2">
                            <a href="<?php echo baseUrl('admin/pedidos'); ?>" class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-arrow-right me-1"></i>Ver Todos
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-card-checklist fa-2x text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start-info border-start-4 shadow-sm h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">Mensajes de Contacto</div>
                        <div class="h5 mb-0 fw-bold text-gray-800"><?php echo $totalMensajes; ?></div>
                        <div class="mt-2">
                            <?php if ($mensajesNoLeidos > 0): ?>
                                <span class="badge bg-danger me-2"><?php echo $mensajesNoLeidos; ?> nuevos</span>
                            <?php endif; ?>
                            <a href="<?php echo baseUrl('admin/contacto'); ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-arrow-right me-1"></i>Responder
                            </a>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-envelope fa-2x text-info opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividad Reciente - Diseño Mejorado -->
<div class="row">
    <!-- Últimos Usuarios -->
    <div class="col-xl-3 col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="bi bi-people me-2"></i>Últimos Usuarios</h6>
                    <span class="badge bg-light text-primary"><?php echo count($ultimosUsuarios); ?></span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($ultimosUsuarios as $usuario): ?>
                        <div class="list-group-item d-flex align-items-center py-3">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold"><?php echo e($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h6>
                                <p class="mb-0 small text-muted"><?php echo e($usuario['correo']); ?></p>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <small class="text-muted"><?php echo fechaFormatoHumano($usuario['created_at']); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-arrow-right me-1"></i>Ver todos los usuarios
                </a>
            </div>
        </div>
    </div>

    <!-- Últimos Productos -->
    <div class="col-xl-3 col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-success text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="bi bi-box me-2"></i>Últimos Productos</h6>
                    <span class="badge bg-light text-success"><?php echo count($ultimosProductos); ?></span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($ultimosProductos as $producto): ?>
                        <div class="list-group-item d-flex align-items-center py-3">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                    <i class="bi bi-tag text-success"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1 fw-semibold text-truncate"><?php echo e($producto['nombre']); ?></h6>
                                <p class="mb-0 small text-success fw-bold">$<?php echo number_format($producto['precio'], 0); ?></p>
                            </div>
                            <div class="flex-shrink-0 text-end">
                                <small class="text-muted"><?php echo fechaFormatoHumano($producto['created_at']); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-sm btn-outline-success w-100">
                    <i class="bi bi-arrow-right me-1"></i>Ver catálogo completo
                </a>
            </div>
        </div>
    </div>

    <!-- Últimos Pedidos -->
    <div class="col-xl-3 col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning text-dark py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="bi bi-cart me-2"></i>Últimos Pedidos</h6>
                    <span class="badge bg-light text-warning"><?php echo count($ultimosPedidos); ?></span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($ultimosPedidos as $pedido): ?>
                        <div class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1 fw-semibold">Pedido #<?php echo $pedido['id']; ?></h6>
                                    <p class="mb-1 small text-muted"><?php echo e($pedido['usuario_nombre'] ?? 'Cliente'); ?></p>
                                </div>
                                <span class="badge bg-<?php echo obtenerColorEstado($pedido['estado']); ?>">
                                    <?php echo ucfirst($pedido['estado']); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold text-warning">$<?php echo number_format($pedido['total'], 0); ?></span>
                                <small class="text-muted"><?php echo fechaFormatoHumano($pedido['created_at']); ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="<?php echo baseUrl('admin/pedidos'); ?>" class="btn btn-sm btn-outline-warning w-100">
                    <i class="bi bi-arrow-right me-1"></i>Gestionar pedidos
                </a>
            </div>
        </div>
    </div>

    <!-- Últimos Mensajes -->
    <div class="col-xl-3 col-lg-6 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold"><i class="bi bi-envelope me-2"></i>Últimos Mensajes</h6>
                    <span class="badge bg-light text-info"><?php echo count($ultimosMensajes); ?></span>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <?php foreach($ultimosMensajes as $mensaje): ?>
                        <div class="list-group-item py-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-semibold text-truncate"><?php echo e($mensaje['nombre']); ?></h6>
                                    <p class="mb-1 small text-muted text-truncate"><?php echo e($mensaje['correo']); ?></p>
                                    <p class="mb-1 small"><?php echo e($mensaje['asunto']); ?></p>
                                </div>
                                <?php if (!$mensaje['leido']): ?>
                                    <span class="badge bg-danger ms-2">Nuevo</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted"><?php echo fechaFormatoHumano($mensaje['created_at']); ?></small>
                                <a href="<?php echo baseUrl('admin/contacto/ver/' . $mensaje['id']); ?>" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="<?php echo baseUrl('admin/contacto'); ?>" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-arrow-right me-1"></i>Ver todos los mensajes
                </a>
            </div>
        </div>
    </div>
</div>