<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Movimiento - Sistema de Stock</title>
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
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;}
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .btn { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; color: white; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb; }
        .stock-info { background: #e9ecef; padding: 10px; border-radius: 4px; margin-top: 5px; font-size: 14px; color: #495057; display: none; }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="nav-links">
            <a href="/tp_stock/dashboard.php">Dashboard</a>
            <a href="/tp_stock/products.php">Productos</a>
            <a href="/tp_stock/movements.php">Movimientos</a>
            <a href="/tp_stock/logout.php">Salir</a>
        </div>
    </div>

    <div class="container">
        <h2>🔄 Registrar Movimiento de Stock</h2>

        <?php if ($error): ?>
            <div class="alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="id_producto">Producto *</label>
                <select id="id_producto" name="id_producto" required onchange="mostrarStock()">
                    <option value="">Seleccionar producto...</option>
                    <?php foreach ($productos as $p): ?>
                        <option value="<?= $p['id'] ?>" data-stock="<?= $p['stock'] ?>">
                            <?= htmlspecialchars($p['sku'] . ' - ' . $p['nombre']) ?> (Stock: <?= $p['stock'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <div id="stock-display" class="stock-info"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="tipo">Tipo de Movimiento *</label>
                    <select id="tipo" name="tipo" required>
                        <option value="entrada">🟢 Entrada (Suma stock)</option>
                        <option value="salida">🔴 Salida (Resta stock)</option>
                        <option value="ajuste">🟡 Ajuste (Manual)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad *</label>
                    <input type="number" id="cantidad" name="cantidad" min="1" required>
                </div>
            </div>

            <div class="form-group">
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones" rows="3" placeholder="Ej: Compra a proveedor X, Venta a cliente Y, Rotura de mercadería..."></textarea>
            </div>

            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">💾 Registrar Movimiento</button>
                <a href="/tp_stock/dashboard.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script>
        function mostrarStock() {
            const select = document.getElementById('id_producto');
            const display = document.getElementById('stock-display');
            const opcionSeleccionada = select.options[select.selectedIndex];
            
            if (opcionSeleccionada.value) {
                const stock = opcionSeleccionada.getAttribute('data-stock');
                display.style.display = 'block';
                display.innerHTML = '📦 <strong>Stock actual disponible:</strong> ' + stock + ' unidades';
            } else {
                display.style.display = 'none';
            }
        }
    </script>

</body>
</html>