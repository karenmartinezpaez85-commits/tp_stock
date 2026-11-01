<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos - Sistema de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .navbar { background: #667eea; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 20px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.2); }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .header-section { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-size: 14px; cursor: pointer; display: inline-block; }
        .btn-new { background: #6f42c1; color: white; }
        .btn-new:hover { background: #5a32a3; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .badge { padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: bold; }
        .badge-entrada { background: #d4edda; color: #155724; }
        .badge-salida { background: #f8d7da; color: #721c24; }
        .badge-ajuste { background: #fff3cd; color: #856404; }
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
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
            <a href="/tp_stock/movements.php" class="active">Movimientos</a>
            <a href="/tp_stock/logout.php" style="background: #ff4444;">Salir</a>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($feedback)): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($feedback) ?>
            </div>
        <?php endif; ?>

        <div class="header-section">
            <h2>📋 Historial de Movimientos</h2>
            <a href="/tp_stock/movement_create.php" class="btn btn-new">🔄 Nuevo Movimiento</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Usuario</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($movimientos) > 0): ?>
                    <?php foreach ($movimientos as $mov): ?>
                    <tr>
                        <td><?= $mov['id'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($mov['fecha'])) ?></td>
                        <td><strong><?= htmlspecialchars($mov['producto']) ?></strong></td>
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
                <?php else: ?>
                    <tr><td colspan="7" style="text-align: center; color: #777;">No hay movimientos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>