<?php
require_once 'config/database.php';
require_once 'models/CategoryModel.php';

session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /tp_stock/index.php'); exit; }

$categoryModel = new CategoryModel();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['nombre' => trim($_POST['nombre']), 'descripcion' => trim($_POST['descripcion'])];
    if (empty($data['nombre'])) {
        $error = "El nombre de la categoría es obligatorio.";
    } elseif ($categoryModel->create($data)) {
        header('Location: /tp_stock/categories.php?msg=created');
        exit;
    } else {
        $error = "Error al crear la categoría.";
    }
}
?>
<!-- Vista inline simple para el alta -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Nueva Categoría</title>
    <style>body{font-family:Arial;padding:40px;max-width:600px;margin:0 auto;} input,textarea{width:100%;padding:10px;margin:10px 0;} button{padding:10px 20px;background:#28a745;color:white;border:none;cursor:pointer;} .error{color:red;}</style>
</head>
<body>
    <h2>➕ Nueva Categoría</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <label>Nombre *</label>
        <input type="text" name="nombre" required>
        <label>Descripción</label>
        <textarea name="descripcion" rows="3"></textarea>
        <button type="submit">Guardar</button>
        <a href="/tp_stock/categories.php" style="margin-left:10px;">Cancelar</a>
    </form>
</body>
</html>