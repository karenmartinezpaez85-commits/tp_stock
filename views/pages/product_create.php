<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Producto - Sistema de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; }
        .navbar { background: #667eea; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 20px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 800px; margin: 30px auto; padding: 30px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px;
        }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #28a745; color: white; }
        .btn-primary:hover { background: #218838; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert { padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="nav-links">
            <a href="products.php">← Volver al Listado</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php">Salir</a>
        </div>
    </div>

    <div class="container">
        <h2>➕ Nuevo Producto</h2>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?= $success ?> <a href="products.php" style="color: #155724; font-weight: bold;">Ver listado</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label for="sku">SKU (Código único) *</label>
                    <input type="text" id="sku" name="sku" value="<?= htmlspecialchars($data['sku']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre del Producto *</label>
                    <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($data['nombre']) ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($data['descripcion']) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="id_categoria">Categoría *</label>
                    <select id="id_categoria" name="id_categoria" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($data['id_categoria']) && $data['id_categoria'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_proveedor">Proveedor *</label>
                    <select id="id_proveedor" name="id_proveedor" required>
                        <option value="">Seleccionar...</option>
                        <?php foreach ($proveedores as $prov): ?>
                            <option value="<?= $prov['id'] ?>" <?= (isset($data['id_proveedor']) && $data['id_proveedor'] == $prov['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($prov['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="precio_compra">Precio de Compra ($) *</label>
                    <input type="number" step="0.01" id="precio_compra" name="precio_compra" value="<?= htmlspecialchars($data['precio_compra']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="precio_venta">Precio de Venta ($) *</label>
                    <input type="number" step="0.01" id="precio_venta" name="precio_venta" value="<?= htmlspecialchars($data['precio_venta']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stock">Stock Inicial *</label>
                    <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($data['stock']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="stock_minimo">Stock Mínimo (Alerta) *</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" value="<?= htmlspecialchars($data['stock_minimo']) ?>" required>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Guardar Producto</button>
                <a href="products.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>