<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="bi bi-box-seam"></i> Gestión de Productos</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo baseUrl('admin/productos/crear'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Producto
        </a>
    </div>
</div>

<!-- búsqueda -->
<form method="get" class="row g-2 mb-3">
    <div class="col-md-8">
        <input type="search" name="q" class="form-control" placeholder="Buscar por nombre o categoría"
               value="<?php echo e($_GET['q'] ?? ''); ?>">
    </div>
    <div class="col-md-4 text-end">
        <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-link">Limpiar</a>
    </div>
</form>

<!-- select de cantidad de registros -->
<form method="get" class="mb-3 d-flex align-items-center">
    <label class="me-2">Mostrar:</label>
    <select name="limit" class="form-select w-auto me-2" onchange="this.form.submit()">
        <?php foreach ([5, 10, 25, 50] as $op): ?>
            <option value="<?= $op ?>" <?= (!isset($_GET['limit']) && $op==5) || (isset($_GET['limit']) && $_GET['limit']==$op) ? 'selected' : '' ?>>
                <?= $op ?>
            </option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (empty($productos)): ?>
    <div class="alert alert-info"><i class="bi bi-info-circle"></i> No hay productos aún.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $p): ?>
                    <tr>
                        <td style="width:80px;">
                            <?php if (!empty($p['imagen'])): ?>
                                <img src="<?php echo baseUrl($p['imagen']); ?>" alt="" style="max-width:64px; max-height:64px; object-fit:cover;">
                            <?php else: ?>
                                <span class="text-muted small">Sin imagen</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?php echo e($p['nombre']); ?></strong><br><small class="text-muted"><?php echo e(substr($p['descripcion'],0,60)); ?></small></td>
                        <td>$ <?= number_format($p['precio'], 0, ',', '.'); ?></td>
                        <td><?php echo e($p['stock']); ?></td>
                        <td><?= e($p['categoria']); ?></td>
                        <td><?php echo $p['activo'] ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-secondary">Inactivo</span>'; ?></td>
                        <td><small><?php echo date('d/m/Y', strtotime($p['created_at'])); ?></small></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?php echo baseUrl('admin/productos/editar/' . $p['id']); ?>" class="btn btn-warning" title="Editar"><i class="bi bi-pencil"></i></a>
                                <a href="<?php echo baseUrl('admin/productos/eliminar/' . $p['id']); ?>" class="btn btn-danger" title="Eliminar"
                                   onclick="return confirm('¿Eliminar este producto?');"><i class="bi bi-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <?php if ($totalPaginas > 1): ?>
    <nav>
        <ul class="pagination">
            <?php for ($p = 1; $p <= $totalPaginas; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?q=<?= urlencode($q) ?>&limit=<?= $limit ?>&page=<?= $p ?>">
                        <?= $p ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
<?php endif; ?>
