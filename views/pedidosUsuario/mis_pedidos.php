<section class="mis-pedidos py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <h1 class="h2 mb-0 fw-bold">Mis Pedidos</h1>
                </div>
                
                <?php if (empty($pedidos)): ?>
                    <div class="card shadow-sm border-0 text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                            <h3 class="text-muted mb-3">No tienes pedidos realizados</h3>
                            <p class="text-muted mb-4">¡Explora nuestro catálogo y descubre productos increíbles!</p>
                            <a href="<?php echo baseUrl('catalogo'); ?>" class="btn btn-primary btn-lg">
                                <i class="bi bi-bag me-2"></i>Ir de Compras
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-list-ul me-2"></i>Historial de Pedidos
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>N° Pedido</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td class="fw-semibold">#<?php echo $pedido['id']; ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($pedido['created_at'])); ?></td>
                                            <td class="fw-bold text-primary">$<?php echo number_format($pedido['total'], 0, ',', '.'); ?></td>
                                            <td>
                                                <span class="badge badge-estado badge-<?php echo $pedido['estado']; ?>">
                                                    <?php echo ucfirst($pedido['estado']); ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo baseUrl('pedidosUsuario/ver/' . $pedido['id']); ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Ver Detalle
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>