<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="bi bi-envelope"></i> Mensajes de Contacto</h1>
    </div>
    <div class="col-md-4 text-end">
        <span class="badge bg-info me-2">Total: <?php echo $totalMensajes; ?></span>
        <?php if ($totalNoLeidos > 0): ?>
            <span class="badge bg-danger">No leídos: <?php echo $totalNoLeidos; ?></span>
        <?php endif; ?>
    </div>
</div>

<!-- Filtros y búsqueda -->
<form method="get" class="row g-2 mb-3">
    <div class="col-md-6">
        <input type="search" name="q" class="form-control" 
               placeholder="Buscar por nombre, correo o asunto..." 
               value="<?php echo e($q ?? ''); ?>">
    </div>
    <div class="col-md-6 text-end">
        <button class="btn btn-outline-primary"><i class="bi bi-search"></i> Buscar</button>
        <a href="<?php echo baseUrl('admin/contacto'); ?>" class="btn btn-link">Limpiar</a>
        
        <div class="btn-group ms-2">
            <a href="<?php echo baseUrl('admin/contacto'); ?>" 
               class="btn btn-outline-secondary <?php echo !isset($_GET['filtro']) ? 'active' : ''; ?>">
                Todos
            </a>
            <a href="<?php echo baseUrl('admin/contacto?filtro=no-leidos'); ?>" 
               class="btn btn-outline-danger <?php echo ($_GET['filtro'] ?? '') === 'no-leidos' ? 'active' : ''; ?>">
                No Leídos
            </a>
        </div>
    </div>
</form>

<?php if(empty($mensajes)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> No hay mensajes de contacto.
    </div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th width="40"></th>
                <th>Remitente</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th width="100">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($mensajes as $mensaje): ?>
                <tr class="<?php echo !$mensaje['leido'] ? 'table-warning' : ''; ?>">
                    <td class="text-center">
                        <?php if (!$mensaje['leido']): ?>
                            <span class="badge bg-danger" title="No leído">
                                <i class="bi bi-envelope"></i>
                            </span>
                        <?php else: ?>
                            <span class="text-muted" title="Leído">
                                <i class="bi bi-envelope-open"></i>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div>
                            <strong><?php echo e($mensaje['nombre']); ?></strong>
                            <br>
                            <small class="text-muted"><?php echo e($mensaje['correo']); ?></small>
                        </div>
                    </td>
                    <td>
                        <strong><?php echo e($mensaje['asunto']); ?></strong>
                    </td>
                    <td>
                        <p class="mb-0 text-truncate" style="max-width: 200px;">
                            <?php echo e($mensaje['mensaje']); ?>
                        </p>
                    </td>
                    <td>
                        <small class="text-muted">
                            <?php echo fechaFormatoHumano($mensaje['created_at']); ?>
                        </small>
                    </td>
                    <td>
                        <div class="btn-group btn-group-sm">
                            <a href="<?php echo baseUrl('admin/contacto/ver/' . $mensaje['id']); ?>" 
                               class="btn btn-info btn-sm" 
                               title="Ver mensaje">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?php echo baseUrl('admin/contacto/eliminar/' . $mensaje['id']); ?>" 
                               class="btn btn-danger btn-sm" 
                               title="Eliminar mensaje"
                               onclick="return confirm('¿Estás seguro de que quieres eliminar este mensaje?')">
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
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($pnum = 1; $pnum <= $totalPaginas; $pnum++): ?>
                <li class="page-item <?= $pnum == $page ? 'active' : '' ?>">
                    <a class="page-link" 
                       href="<?php echo baseUrl('admin/contacto'); ?>?page=<?php echo $pnum; ?>&q=<?php echo urlencode($q ?? ''); ?>&filtro=<?php echo urlencode($_GET['filtro'] ?? ''); ?>">
                        <?php echo $pnum; ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
<?php endif; ?>
<?php endif; ?>