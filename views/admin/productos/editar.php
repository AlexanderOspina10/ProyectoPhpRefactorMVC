<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-pencil"></i> Editar Producto</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo baseUrl('admin/productos/actualizar'); ?>" method="POST" enctype="multipart/form-data">
                    <?php campoTokenCSRF(); ?>
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required maxlength="100" value="<?php echo e($producto['nombre']); ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"><?php echo e($producto['descripcion']); ?></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" required value="<?php echo e($producto['precio']); ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" value="<?php echo e($producto['stock']); ?>" required>
                        </div>
                        <hr>
                       <br> 
                      <select name="categoria" id="categoria" class="form-control" required>
                        <option value="">-- Seleccione --</option>
                        <?php 
                            $catSelected = $_POST['categoria'] ?? $producto['categoria'];
                            $categorias = ['Hombre','Mujer','Accesorios','Otros'];
                            foreach($categorias as $c): 
                        ?>
                            <option value="<?= $c ?>" <?= ($catSelected==$c)?'selected':'' ?>><?= $c ?></option>
                        <?php endforeach; ?>
                    </select>
                    <hr>
                    <br>

                    <div class="mb-3">
                        <label class="form-label">Imagen actual</label><br>
                        <?php if (!empty($producto['imagen'])): ?>
                            <img src="<?php echo baseUrl($producto['imagen']); ?>" alt="" style="max-width:150px; max-height:150px; object-fit:cover;">
                        <?php else: ?>
                            <div class="alert alert-secondary small">Sin imagen</div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cambiar imagen (opcional)</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                        <small class="text-muted">Si subes una nueva imagen, reemplazará a la anterior.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="activo" class="form-select" required>
                            <option value="1" <?php echo ($producto['activo']==1)?'selected':''; ?>>Activo</option>
                            <option value="0" <?php echo ($producto['activo']==0)?'selected':''; ?>>Inactivo</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
