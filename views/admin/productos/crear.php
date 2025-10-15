<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Crear Nuevo Producto</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo baseUrl('admin/productos/guardar'); ?>" method="POST" enctype="multipart/form-data">
                    <?php campoTokenCSRF(); ?>

                    <div class="mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required maxlength="100">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Precio</label>
                            <input type="number" step="0.01" name="precio" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control" value="0" required>
                        </div>
                        <br>
                        <hr>
                       <select name="categoria" id="categoria" class="form-control" required>
                            <option value="">-- Seleccione --</option>
                            <?php 
                                $catSelected = $_POST['categoria'] ?? '';
                                $categorias = ['Hombre','Mujer','Accesorios','Otros'];
                                foreach($categorias as $c): 
                            ?>
                                <option value="<?= $c ?>" <?= ($catSelected==$c)?'selected':'' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                        <hr>
                    <div class="mb-3">
                        <label class="form-label">Imagen (JPG, PNG, WEBP) - máx 2MB</label>
                        <input type="file" name="imagen" class="form-control" accept="image/*">
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo baseUrl('admin/productos'); ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Crear Producto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
