<?php
// Verificar que el carrito no esté vacío
if (empty($_SESSION['carrito'])) {
    header('Location: ' . baseUrl('catalogo'));
    exit;
}
?>

<section class="finalizar-pedido py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex align-items-center mb-4">
                    <a href="<?php echo baseUrl('catalogo'); ?>" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-arrow-left me-2"></i>Volver al Catálogo
                    </a>
                    <h1 class="h2 mb-0 fw-bold">Finalizar Pedido</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Resumen del Pedido e Información de Envío -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0 fw-semibold">
                            <i class="bi bi-list-check me-2"></i>Resumen de tu Pedido
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="80">Producto</th>
                                        <th>Descripción</th>
                                        <th class="text-center" width="100">Cantidad</th>
                                        <th class="text-end" width="120">Precio Unit.</th>
                                        <th class="text-end" width="120">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $totalPedido = 0;
                                    foreach ($_SESSION['carrito'] as $item): 
                                        $subtotal = $item['precio'] * $item['cantidad'];
                                        $totalPedido += $subtotal;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($item['imagen'])): ?>
                                                <img src="<?php echo baseUrl($item['imagen']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['nombre']); ?>" 
                                                     class="img-fluid rounded" 
                                                     style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 60px; height: 60px;">
                                                    <i class="bi bi-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <h6 class="mb-1 fw-semibold"><?php echo htmlspecialchars($item['nombre']); ?></h6>
                                            <small class="text-muted">Código: PROD-<?php echo $item['producto_id']; ?></small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary fs-6"><?php echo $item['cantidad']; ?></span>
                                        </td>
                                        <td class="text-end">
                                            $<?php echo number_format($item['precio'], 0, ',', '.'); ?>
                                        </td>
                                        <td class="text-end fw-bold text-primary">
                                            $<?php echo number_format($subtotal, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold fs-5">Total:</td>
                                        <td class="text-end fw-bold fs-5 text-primary">
                                            $<?php echo number_format($totalPedido, 0, ',', '.'); ?>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
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
                        <form action="<?php echo baseUrl('pedidosUsuario/procesar'); ?>" method="POST" id="form-pedido">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                                    <input type="text" class="form-control form-control-lg" 
                                           value="<?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?>" 
                                           readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                                    <input type="email" class="form-control form-control-lg" 
                                           value="<?php echo htmlspecialchars($usuario['correo']); ?>" 
                                           readonly>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="direccion" class="form-label fw-semibold">
                                    Dirección de Envío <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="direccion" name="direccion" 
                                          rows="3" required placeholder="Ingresa tu dirección completa para el envío"><?php echo htmlspecialchars($usuario['direccion'] ?? ''); ?></textarea>
                                <div class="form-text">
                                    Incluye ciudad, barrio, calle, número y referencias.
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label fw-semibold">
                                        Teléfono de Contacto <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                                           value="<?php echo htmlspecialchars($usuario['telefono'] ?? ''); ?>" 
                                           required placeholder="Ej: +57 300 123 4567">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="notas" class="form-label fw-semibold">Notas Adicionales</label>
                                    <input type="text" class="form-control" id="notas" name="notas" 
                                           placeholder="Instrucciones especiales para la entrega">
                                </div>
                            </div>
                            
                            <!-- Sección de Ayuda movida aquí -->
                            <div class="card shadow-sm border-0 mt-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">
                                        <i class="bi bi-headset me-2"></i>¿Necesitas ayuda?
                                    </h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-whatsapp me-2 text-success fs-5"></i>
                                                <div>
                                                    <small class="fw-semibold d-block">WhatsApp</small>
                                                    <small class="text-muted">+57 311 323 5370</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-envelope me-2 text-primary fs-5"></i>
                                                <div>
                                                    <small class="fw-semibold d-block">Email</small>
                                                    <small class="text-muted">Fashion31store@gmail.com</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-clock me-2 text-warning fs-5"></i>
                                                <div>
                                                    <small class="fw-semibold d-block">Horario</small>
                                                    <small class="text-muted">Lun-Sab 8:00 AM - 9:00 PM</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info mt-4">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-info-circle fs-4 me-3"></i>
                                    <div>
                                        <h6 class="mb-1 fw-semibold">Información Importante</h6>
                                        <p class="mb-0 small">
                                            Tu pedido será procesado inmediatamente. Te contactaremos para confirmar 
                                            los detalles de envío y pago. Tiempo estimado de entrega: 2-5 días hábiles.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Resumen Final - Sidebar -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-success text-white py-3">
                            <h5 class="mb-0 fw-semibold">
                                <i class="bi bi-bag-check me-2"></i>Confirmar Pedido
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-semibold">Productos:</span>
                                <span><?php echo count($_SESSION['carrito']); ?> items</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-semibold">Subtotal:</span>
                                <span>$<?php echo number_format($totalPedido, 0, ',', '.'); ?></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="fw-semibold">Envío:</span>
                                <span class="text-success">Gratis</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <span class="fw-bold fs-5">Total:</span>
                                <span class="fw-bold fs-5 text-primary">$<?php echo number_format($totalPedido, 0, ',', '.'); ?></span>
                            </div>
                            
                            <button type="submit" form="form-pedido" class="btn btn-success btn-lg w-100 py-3 fw-bold mb-3">
                                <i class="bi bi-check-circle me-2"></i>
                                Confirmar y Realizar Pedido
                            </button>
                            
                            <div class="text-center">
                                <small class="text-muted">
                                    Al confirmar, aceptas nuestros 
                                    <a href="#" class="text-decoration-none">términos y condiciones</a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>