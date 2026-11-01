<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías - Sistema de Stock</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .navbar { background: #667eea; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h1 { font-size: 20px; }
        .nav-links { display: flex; gap: 20px; align-items: center; }
        .nav-links a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
        .nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.2); }
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .header-section { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; text-decoration: none; font-size: 14px; cursor: pointer; display: inline-block; }
        .btn-new { background: #28a745; color: white; }
        .btn-new:hover { background: #218838; }
        .btn-edit { background: #ffc107; color: #333; padding: 6px 12px; font-size: 12px; }
        .btn-delete { background: #dc3545; color: white; padding: 6px 12px; font-size: 12px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        table { width: 100%; background: white; border-collapse: collapse; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f8f9fa; font-weight: bold; }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="nav-links">
            <a href="/tp_stock/dashboard.php">Dashboard</a>
            <a href="/tp_stock/products.php">Productos</a>
            <a href="/tp_stock/categories.php" class="active">Categorías</a>
            <a href="/tp_stock/logout.php" style="background: #ff4444;">Salir</a>
        </div>
    </div>

    <div class="container">
        <?php if (!empty($feedback)): ?>
            <div class="alert <?= strpos($feedback, '✅') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= htmlspecialchars($feedback) ?>
            </div>
        <?php endif; ?>

        <div class="header-section">
            <h2>📂 Gestión de Categorías</h2>
            <a href="/tp_stock/category_create.php" class="btn btn-new">➕ Nueva Categoría</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th style="width: 150px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($categorias) > 0): ?>
                    <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><strong><?= htmlspecialchars($cat['nombre']) ?></strong></td>
                        <td><?= htmlspecialchars($cat['descripcion'] ?: 'Sin descripción') ?></td>
                        <td>
                            <a href="/tp_stock/category_edit.php?id=<?= $cat['id'] ?>" class="btn btn-edit">Editar</a>
                            <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                            <a href="/tp_stock/category_delete.php?id=<?= $cat['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Seguro que querés eliminar esta categoría? Si tiene productos asociados, no se podrá borrar.')">Eliminar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" style="text-align: center; color: #777;">No hay categorías registradas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>