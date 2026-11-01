<?php
require_once 'config/database.php';
require_once 'models/CategoryModel.php';

session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /tp_stock/index.php'); exit; }

$categoryModel = new CategoryModel();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$category = $categoryModel->getById($id);
$error = '';

if (!$category) { header('Location: /tp_stock/categories.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = ['id' => $id, 'nombre' => trim($_POST['nombre']), 'descripcion' => trim($_POST['descripcion'])];
    if (empty($data['nombre'])) {
        $error = "El nombre es obligatorio.";
    } elseif ($categoryModel->update($data)) {
        header('Location: /tp_stock/categories.php?msg=updated');
        exit;
    } else {
        $error = "Error al actualizar.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Editar Categoría</title>
    <style>body{font-family:Arial;padding:40px;max-width:600px;margin:0 auto;} input,textarea{width:100%;padding:10px;margin:10px 0;} button{padding:10px 20px;background:#ffc107;color:#333;border:none;cursor:pointer;} .error{color:red;}</style>
</head>
<body>
    <h2>✏️ Editar Categoría</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <label>Nombre *</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($category['nombre']) ?>" required>
        <label>Descripción</label>
        <textarea name="descripcion" rows="3"><?= htmlspecialchars($category['descripcion']) ?></textarea>
        <button type="submit">Actualizar</button>
        <a href="/tp_stock/categories.php" style="margin-left:10px;">Cancelar</a>
    </form>
</body>
</html>