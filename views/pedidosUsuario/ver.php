<section class="detalle-pedido py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <a href="<?php echo baseUrl('pedidosUsuario/mis_pedidos'); ?>" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left me-2"></i>Volver a Mis Pedidos
                    </a>
                    <h1 class="h2 mb-0 fw-bold">Pedido #<?php echo $pedido['id']; ?></h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Detalle de Productos -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-box-seam me-2"></i>Productos del Pedido
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-end">Precio Unit.</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedido['detalle'] as $item): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($item['imagen'])): ?>
                                                    <img src="<?php echo baseUrl($item['imagen']); ?>" 
                                                         alt="<?php echo htmlspecialchars($item['producto_nombre']); ?>" 
                                                         class="img-fluid rounded me-3" 
                                                         style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($item['producto_nombre']); ?></h6>
                                                    <small class="text-muted">Código: PROD-<?php echo $item['producto_id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6"><?php echo $item['cantidad']; ?></span>
                                        </td>
                                        <td class="text-end">
                                            $<?php echo number_format($item['precio_unitario'], 0, ',', '.'); ?>
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            $<?php echo number_format($item['precio_unitario'] * $item['cantidad'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold fs-5">Total:</td>
                                        <td class="text-end fw-bold fs-5 text-primary">
                                            $<?php echo number_format($pedido['total'], 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Información del Pedido -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-info-circle me-2"></i>Información del Pedido
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Estado:</strong>
                            <span class="badge badge-estado badge-<?php echo $pedido['estado']; ?> float-end">
                                <?php echo ucfirst($pedido['estado']); ?>
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Fecha:</strong>
                            <span class="float-end"><?php echo date('d/m/Y H:i', strtotime($pedido['created_at'])); ?></span>
                        </div>
                        <div class="mb-3">
                            <strong>N° Pedido:</strong>
                            <span class="float-end fw-bold">#<?php echo $pedido['id']; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Información de Envío -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-truck me-2"></i>Información de Envío
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>Dirección:</strong>
                            <p class="mb-0 text-muted"><?php echo htmlspecialchars($pedido['direccion_envio']); ?></p>
                        </div>
                        <div class="mb-0">
                            <strong>Teléfono:</strong>
                            <span class="float-end"><?php echo htmlspecialchars($pedido['telefono_envio']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>