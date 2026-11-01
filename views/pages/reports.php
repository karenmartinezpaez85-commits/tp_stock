<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Sistema de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .navbar { background: #667eea; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 20px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.2); }
        .container { max-width: 1400px; margin: 30px auto; padding: 0 20px; }
        .filter-section { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .filter-section h2 { margin-bottom: 20px; color: #333; }
        .filter-form { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .form-group { display: flex; flex-direction: column; }
        .form-group label { font-size: 12px; font-weight: bold; color: #666; margin-bottom: 5px; }
        .form-group input, .form-group select { padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-secondary { background: #6c757d; color: white; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .stat-card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { font-size: 32px; margin: 10px 0; }
        .stat-card.entradas h3 { color: #28a745; }
        .stat-card.salidas h3 { color: #dc3545; }
        .stat-card.ajustes h3 { color: #ffc107; }
        .stat-card.total h3 { color: #667eea; }
        .stat-card p { color: #666; font-size: 14px; margin: 0; }
        .table-container { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .badge-entrada { background: #d4edda; color: #155724; }
        .badge-salida { background: #f8d7da; color: #721c24; }
        .badge-ajuste { background: #fff3cd; color: #856404; }
        .cantidad-positiva { color: #28a745; font-weight: bold; }
        .cantidad-negativa { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="nav-links">
            <a href="/tp_stock/dashboard.php">Dashboard</a>
            <a href="/tp_stock/products.php">Productos</a>
            <a href="/tp_stock/movements.php">Movimientos</a>
            <a href="/tp_stock/reports.php" class="active">Reportes</a>
            <a href="/tp_stock/logout.php" style="background: #ff4444;">Salir</a>
        </div>
    </div>

    <div class="container">
        <!-- Formulario de Filtros -->
        <div class="filter-section">
            <h2>🔍 Filtros de Reporte</h2>
            <form method="POST" class="filter-form">
                <div class="form-group">
                    <label>Fecha Desde</label>
                    <input type="date" name="fecha_desde" value="<?= htmlspecialchars($filters['fecha_desde']) ?>">
                </div>
                <div class="form-group">
                    <label>Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" value="<?= htmlspecialchars($filters['fecha_hasta']) ?>">
                </div>
                <div class="form-group">
                    <label>Tipo de Movimiento</label>
                    <select name="tipo">
                        <option value="todos" <?= $filters['tipo'] === 'todos' ? 'selected' : '' ?>>Todos</option>
                        <option value="entrada" <?= $filters['tipo'] === 'entrada' ? 'selected' : '' ?>>Entradas</option>
                        <option value="salida" <?= $filters['tipo'] === 'salida' ? 'selected' : '' ?>>Salidas</option>
                        <option value="ajuste" <?= $filters['tipo'] === 'ajuste' ? 'selected' : '' ?>>Ajustes</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Producto</label>
                    <select name="id_producto">
                        <option value="">Todos los productos</option>
                        <?php foreach ($productos as $p): ?>
                            <option value="<?= $p['id'] ?>" <?= $filters['id_producto'] == $p['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['sku'] . ' - ' . $p['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group" style="justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">🔍 Filtrar</button>
                </div>
            </form>
        </div>

        <!-- Tarjetas de Resumen -->
        <div class="stats-grid">
            <div class="stat-card total">
                <p>Total de Movimientos</p>
                <h3><?= $resumen['total_movimientos'] ?></h3>
            </div>
            <div class="stat-card entradas">
                <p>Total Entradas</p>
                <h3>+<?= $resumen['total_entradas'] ?: 0 ?></h3>
            </div>
            <div class="stat-card salidas">
                <p>Total Salidas</p>
                <h3>-<?= $resumen['total_salidas'] ?: 0 ?></h3>
            </div>
            <div class="stat-card ajustes">
                <p>Total Ajustes</p>
                <h3><?= $resumen['total_ajustes'] ?: 0 ?></h3>
            </div>
        </div>

        <!-- Tabla de Resultados -->
        <div class="table-container">
            <h2 style="margin-bottom: 20px;">📋 Detalle de Movimientos</h2>
            <?php if (count($movimientos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>SKU</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $mov): ?>
                    <tr>
                        <td><?= $mov['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($mov['fecha'])) ?></td>
                        <td><strong><?= htmlspecialchars($mov['producto']) ?></strong></td>
                        <td><?= htmlspecialchars($mov['sku']) ?></td>
                        <td>
                            <?php
                            $badgeClass = '';
                            $tipoTexto = '';
                            if ($mov['tipo'] === 'entrada') {
                                $badgeClass = 'badge-entrada';
                                $tipoTexto = '🟢 Entrada';
                            } elseif ($mov['tipo'] === 'salida') {
                                $badgeClass = 'badge-salida';
                                $tipoTexto = '🔴 Salida';
                            } else {
                                $badgeClass = 'badge-ajuste';
                                $tipoTexto = '🟡 Ajuste';
                            }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $tipoTexto ?></span>
                        </td>
                        <td class="<?= $mov['tipo'] === 'salida' ? 'cantidad-negativa' : 'cantidad-positiva' ?>">
                            <?= $mov['tipo'] === 'salida' ? '-' : '+' ?><?= $mov['cantidad'] ?>
                        </td>
                        <td><?= htmlspecialchars($mov['usuario']) ?></td>
                        <td><?= htmlspecialchars($mov['observaciones'] ?: '-') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p style="text-align: center; color: #666; padding: 40px;">No se encontraron movimientos con los filtros seleccionados.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>