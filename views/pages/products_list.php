<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Sistema de Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .navbar {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .navbar h1 {
            font-size: 20px;
        }
        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }
        .nav-links a.active {
            background: rgba(255,255,255,0.3);
        }
        .btn-logout {
            background: #ff4444;
        }
        .btn-logout:hover {
            background: #cc0000;
        }
        .container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 20px;
        }
        .header-section {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-section h2 {
            color: #333;
        }
        .search-form {
            display: flex;
            gap: 10px;
        }
        .search-form input {
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            width: 300px;
            font-size: 14px;
        }
        .search-form button {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .search-form button:hover {
            background: #5568d3;
        }
        .btn-new {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-new:hover {
            background: #218838;
        }
        .alert-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-box strong {
            color: #856404;
        }
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            color: #333;
            font-weight: bold;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .stock-low {
            background: #ffcccc;
            color: #cc0000;
            font-weight: bold;
        }
        .stock-ok {
            color: #28a745;
        }
        .badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        .btn-edit {
            background: #ffc107;
            color: #333;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }
        .btn-edit:hover {
            background: #e0a800;
        }
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 3px;
            font-size: 12px;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="products.php" class="active">Productos</a>
            <span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?></span>
            <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>

    <div class="container">
                <?php if (!empty($feedback)): ?>
        <div class="alert-box" style="background: #d4edda; border-color: #c3e6cb; color: #155724;">
            <strong>Éxito:</strong> <?= htmlspecialchars($feedback) ?>
        </div>
        <?php endif; ?>
        <!-- Alerta de stock bajo -->
        <?php if (count($lowStockProducts) > 0): ?>
        <div class="alert-box">
            <strong>⚠️ Alerta:</strong> Hay <?= count($lowStockProducts) ?> producto(s) con stock bajo el mínimo.
        </div>
        <?php endif; ?>

        <!-- Header con búsqueda -->
        <div class="header-section">
            <h2>📋 Listado de Productos</h2>
            <div style="display: flex; gap: 15px; align-items: center;">
                <form method="POST" class="search-form">
                    <input type="text" name="search" placeholder="Buscar por nombre, SKU o categoría..." value="<?= htmlspecialchars($searchTerm) ?>">
                    <button type="submit">Buscar</button>
                </form>
                <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                <a href="product_create.php" class="btn-new">+ Nuevo Producto</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tabla de productos -->
        <div class="table-container">
            <?php if (count($productos) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Proveedor</th>
                        <th>P. Compra</th>
                        <th>P. Venta</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                    <tr class="<?= $producto['stock'] <= $producto['stock_minimo'] ? 'stock-low' : '' ?>">
                        <td><strong><?= htmlspecialchars($producto['sku']) ?></strong></td>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td><?= htmlspecialchars($producto['categoria']) ?></td>
                        <td><?= htmlspecialchars($producto['proveedor']) ?></td>
                        <td>$<?= number_format($producto['precio_compra'], 2) ?></td>
                        <td>$<?= number_format($producto['precio_venta'], 2) ?></td>
                        <td class="<?= $producto['stock'] <= $producto['stock_minimo'] ? 'stock-low' : 'stock-ok' ?>">
                            <?= $producto['stock'] ?> / <?= $producto['stock_minimo'] ?>
                        </td>
                        <td><span class="badge badge-active">Activo</span></td>
                        <td>
                            <a href="product_edit.php?id=<?= $producto['id'] ?>" class="btn-edit">Editar</a>
                            <?php if ($_SESSION['user_rol'] === 'admin'): ?>
                            <a href="product_delete.php?id=<?= $producto['id'] ?>" class="btn-delete" onclick="return confirm('¿Seguro que querés dar de baja este producto?')">Baja</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="empty-state">
                <h3>No se encontraron productos</h3>
                <p>Probá con otra búsqueda o creá un nuevo producto.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>