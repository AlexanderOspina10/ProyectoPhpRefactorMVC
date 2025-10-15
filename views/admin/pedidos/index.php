<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="bi bi-receipt"></i> Gestión de Pedidos</h1>
    </div>
</div>

<form method="get" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="search" name="q" class="form-control" placeholder="Buscar por estado" value="<?= e($_GET['q'] ?? '') ?>">
    </div>
    <div class="col-md-4 text-end">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?= baseUrl('admin/pedidos') ?>" class="btn btn-link">Limpiar</a>
    </div>
</form>

<?php if(empty($pedidos)): ?>
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> No hay pedidos aún.</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Creado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($pedidos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= e($p['usuario_nombre'] . ' ' . $p['usuario_apellido']) ?></td>
                    <td>$ <?= number_format($p['total'],2) ?></td>
                    <td><?= ucfirst($p['estado']) ?></td>
                    <td><?= date('d/m/Y', strtotime($p['created_at'])) ?></td>
                    <td>
                        <a href="<?= baseUrl('admin/pedidos/ver/'.$p['id']) ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                        <a href="<?= baseUrl('admin/pedidos/eliminar/'.$p['id']) ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('¿Eliminar este pedido?');"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
