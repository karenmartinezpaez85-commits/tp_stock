<?php
// Verificar que esté logueado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /tp_stock/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Stock</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .navbar { background: #667eea; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .navbar h1 { font-size: 20px; }
        .user-info { display: flex; align-items: center; gap: 15px; }
        .user-info span { font-size: 14px; }
        .btn { padding: 8px 15px; border-radius: 5px; text-decoration: none; font-size: 14px; color: white; }
        .btn-products { background: #28a745; }
        .btn-products:hover { background: #218838; }
        .btn-logout { background: #ff4444; }
        .btn-logout:hover { background: #cc0000; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .welcome { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .welcome h2 { color: #333; margin-bottom: 15px; }
        .welcome p { color: #666; line-height: 1.6; }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); text-align: center; }
        .stat-card h3 { color: #667eea; font-size: 32px; margin-bottom: 10px; }
        .stat-card p { color: #666; font-size: 14px; }
    </style>
</head>
<body>
     <div class="navbar">
        <h1>📦 Sistema de Control de Stock</h1>
        <div class="user-info">
            <span>👤 <?= htmlspecialchars($_SESSION['user_name']) ?> (<?= htmlspecialchars($_SESSION['user_rol']) ?>)</span>
            
            <!-- Botones de navegación -->
            <a href="/tp_stock/products.php" style="background: #28a745; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 5px;">📦 Productos</a>
            <a href="/tp_stock/categories.php" style="background: #17a2b8; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 5px;">📂 Categorías</a>
            <a href="/tp_stock/providers.php" style="background: #fd7e14; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 5px;">🏭 Proveedores</a>
            <a href="/tp_stock/movement_create.php" class="btn" style="background: #6f42c1; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 10px;">🔄 Nuevo Movimiento</a>
            <a href="/tp_stock/movements.php" class="btn" style="background: #6f42c1; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 10px;">📋 Ver Movimientos</a>
            <a href="/tp_stock/reports.php" class="btn" style="background: #e83e8c; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-right: 10px;">📊 Reportes</a>
            
            <a href="/tp_stock/logout.php" class="btn-logout">Cerrar Sesión</a>
        </div>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
            <p>Has iniciado sesión correctamente. Desde aquí podrás gestionar el inventario de productos, registrar movimientos y generar reportes.</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3>15</h3>
                <p>Productos registrados</p>
            </div>
            <div class="stat-card">
                <h3>5</h3>
                <p>Categorías</p>
            </div>
            <div class="stat-card">
                <h3>3</h3>
                <p>Proveedores</p>
            </div>
            <div class="stat-card">
                <h3>20</h3>
                <p>Movimientos</p>
            </div>
        </div>
    </div>
