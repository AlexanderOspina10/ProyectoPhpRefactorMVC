<h3>Pedido #<?= $pedido['id'] ?></h3>
<p><strong>Usuario:</strong> <?= e($pedido['usuario_nombre'].' '.$pedido['usuario_apellido']) ?></p>
<p><strong>Dirección:</strong> <?= e($pedido['direccion_envio']) ?></p>
<p><strong>Teléfono:</strong> <?= e($pedido['telefono_envio']) ?></p>
<p><strong>Total:</strong> $ <?= number_format($pedido['total'],0) ?></p>
<p><strong>Estado:</strong> <?= ucfirst($pedido['estado']) ?></p>

<h5>Detalle de productos</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($pedido['detalle'] as $item): ?>
        <tr>
            <td><?= e($item['producto_nombre']) ?></td>
            <td><?= $item['cantidad'] ?></td>
            <td>$ <?= number_format($item['precio_unitario'],0) ?></td>
            <td>$ <?= number_format($item['precio_unitario'] * $item['cantidad'],0) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h5>Actualizar estado</h5>
<form method="post" action="<?= baseUrl('admin/pedidos/actualizarEstado') ?>">
    <?php campoTokenCSRF(); ?>
    <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
    <select name="estado" class="form-select w-auto d-inline-block me-2">
        <?php foreach(['pendiente','procesando','enviado','completado','cancelado'] as $e): ?>
            <option value="<?= $e ?>" <?= $pedido['estado']==$e?'selected':'' ?>><?= ucfirst($e) ?></option>
        <?php endforeach; ?>
    </select>
    <button class="btn btn-primary btn-sm">Actualizar</button>
     <a href="<?php echo baseUrl('admin/pedidos'); ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
</form>
