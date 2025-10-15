<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="bi bi-people"></i> Gestión de Usuarios</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="<?php echo baseUrl('admin/usuarios/crear'); ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Usuario
        </a>
    </div>
</div>

<?php if (empty($usuarios)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> No hay usuarios registrados aún.
    </div>
<?php else: ?>
    <!-- Formulario de búsqueda -->
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-8">
            <input type="search" name="q" class="form-control" 
                placeholder="Buscar por correo, nombre o teléfono"
                value="<?php echo e($_GET['q'] ?? ''); ?>">
        </div>
        <div class="col-md-4 text-end">
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-search"></i> Buscar
            </button>
            <a href="<?php echo baseUrl('admin/usuarios'); ?>" class="btn btn-link">
                Limpiar
            </a>
        </div>
    </form>

    <!-- Select de cantidad de registros -->
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

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Correo</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Fecha Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><small><?php echo e($usuario['correo']); ?></small></td>
                        <td><strong><?php echo e($usuario['nombre'] . ' ' . $usuario['apellido']); ?></strong></td>
                        <td><small><?php echo e($usuario['telefono']); ?></small></td>
                        <td><span class="badge bg-info"><?php echo ucfirst(e($usuario['rol_nombre'])); ?></span></td>
                        <td>
                            <?php if ($usuario['activo']): ?>
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i> Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary"><i class="bi bi-x-circle"></i> Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td><small><?php echo date('d/m/Y', strtotime($usuario['created_at'])); ?></small></td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="<?php echo baseUrl('admin/usuarios/editar/' . $usuario['id']); ?>" 
                                   class="btn btn-warning" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?php echo baseUrl('admin/usuarios/eliminar/' . $usuario['id']); ?>" 
                                   class="btn btn-danger" title="Eliminar"
                                   onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    <i class="bi bi-trash"></i>
                                </a>
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
