<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-bg-primary mb-3 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <p class="card-text display-6"><?php echo $totalUsuarios; ?></p>
                    <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-light btn-sm mt-2">Ver Todos</a>
                </div>
                <i class="bi bi-people-fill display-4"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-success mb-3 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Productos</h5>
                    <p class="card-text display-6"><?php echo $totalProductos; ?></p>
                    <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-light btn-sm mt-2">Ver Todos</a>
                </div>
                <i class="bi bi-box-seam display-4"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-bg-warning mb-3 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title">Pedidos</h5>
                    <p class="card-text display-6"><?php echo $totalPedidos; ?></p>
                    <a href="<?php echo baseUrl('admin/pedidos'); ?>" class="btn btn-light btn-sm mt-2">Ver Todos</a>
                </div>
                <i class="bi bi-card-checklist display-4"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <h5 class="mb-3">Últimos Usuarios</h5>
        <ul class="list-group shadow-sm">
            <?php foreach($ultimosUsuarios as $usuario): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-person-circle me-2"></i><?php echo e($usuario['nombre'] . ' ' . $usuario['apellido']); ?></span>
                    <span class="text-muted"><?php echo e($usuario['correo']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-4">
        <h5 class="mb-3">Últimos Productos</h5>
        <ul class="list-group shadow-sm">
            <?php foreach($ultimosProductos as $producto): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-box me-2"></i><?php echo e($producto['nombre']); ?></span>
                    <span class="fw-bold text-success">$<?php echo number_format($producto['precio'], 0); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-md-4">
        <h5 class="mb-3">Últimos Pedidos</h5>
        <ul class="list-group shadow-sm">
            <?php foreach($ultimosPedidos as $pedido): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-cart-check me-2"></i>Pedido #<?php echo $pedido['id']; ?> - <?php echo e($pedido['usuario_nombre'] . ' ' . $pedido['usuario_apellido']); ?></span>
                    <span class="badge bg-warning text-dark"><?php echo ucfirst($pedido['estado']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
