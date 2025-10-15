<div class="carrito-panel">
    <div class="carrito-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">🛒 Tu Carrito</h5>
        <button class="btn-close" id="btn-cerrar-carrito" title="Cerrar carrito"></button>
    </div>

    <div class="carrito-items">
        <?php if (empty($carrito)): ?>
            <div class="carrito-vacio">
                <i class="bi bi-cart-x"></i>
                <p class="mb-0">Tu carrito está vacío</p>
                <a href="<?php echo baseUrl('catalogo#Catalogo'); ?>" class="btn btn-primary mt-3 px-4 py-2">
                    <i class="bi bi-bag me-2"></i>Explorar Productos
                </a>
            </div>
        <?php else: ?>
            <?php foreach ($carrito as $item): ?>
                <div class="carrito-item d-flex align-items-start gap-3">
                    <?php if (!empty($item['imagen'])): ?>
                        <img src="<?php echo baseUrl($item['imagen']); ?>" alt="<?php echo e($item['nombre']); ?>" class="carrito-item-img rounded" width="70" height="70">
                    <?php else: ?>
                        <div class="carrito-item-img-placeholder bg-light rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-image text-muted fs-4"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="carrito-item-info">
                        <h6 class="carrito-item-nombre"><?php echo e($item['nombre']); ?></h6>
                        <div class="carrito-item-precio">
                            $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
                        </div>
                        
                        <div class="cantidad-controls d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary disminuir-cantidad" data-producto-id="<?php echo $item['producto_id']; ?>">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="cantidad-value"><?php echo $item['cantidad']; ?></span>
                            <button class="btn btn-sm btn-outline-secondary aumentar-cantidad" data-producto-id="<?php echo $item['producto_id']; ?>">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        
                        <div class="carrito-item-subtotal">
                            Subtotal: $<?php echo number_format($item['precio'] * $item['cantidad'], 0, ',', '.'); ?>
                        </div>
                    </div>
                    
                    <button class="btn btn-sm btn-outline-danger eliminar-item" data-producto-id="<?php echo $item['producto_id']; ?>" title="Eliminar del carrito">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php if (!empty($carrito)): ?>
        <div class="carrito-total d-flex justify-content-between align-items-center">
            <strong class="fs-5">Total:</strong>
            <strong class="text-primary fs-4">$<?php echo number_format($total, 0, ',', '.'); ?></strong>
        </div>

        <div class="carrito-actions">
            <a href="<?php echo baseUrl('pedidosUsuario/finalizar'); ?>" class="btn btn-primary w-100 mb-2 fw-semibold <?php echo !estaAutenticado() ? 'disabled' : ''; ?>" id="btn-finalizar-pedido">
                    <i class="bi bi-bag-check me-2"></i>Finalizar Pedido
                </a>
            
            <?php if (!estaAutenticado()): ?>
                <div class="alert alert-warning text-center py-2 mb-2">
                    <small class="fw-semibold">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        Debes <a href="<?php echo baseUrl('login'); ?>" class="alert-link">iniciar sesión</a> para finalizar tu compra
                    </small>
                </div>
            <?php endif; ?>
            
            <button class="btn btn-outline-danger w-100" id="btn-vaciar-carrito">
                <i class="bi bi-trash me-2"></i>Vaciar Carrito
            </button>
        </div>
    <?php endif; ?>
</div>