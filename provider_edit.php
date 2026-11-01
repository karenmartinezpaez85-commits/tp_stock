<?php
require_once 'config/database.php';
require_once 'models/ProviderModel.php';

session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /tp_stock/index.php'); exit; }

$providerModel = new ProviderModel();
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$provider = $providerModel->getById($id);
$error = '';

if (!$provider) { header('Location: /tp_stock/providers.php'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id'        => $id,
        'nombre'    => trim($_POST['nombre']),
        'contacto'  => trim($_POST['contacto']),
        'telefono'  => trim($_POST['telefono']),
        'email'     => trim($_POST['email'])
    ];
    if (empty($data['nombre'])) {
        $error = "El nombre es obligatorio.";
    } elseif ($providerModel->update($data)) {
        header('Location: /tp_stock/providers.php?msg=updated');
        exit;
    } else {
        $error = "Error al actualizar.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Editar Proveedor</title>
    <style>body{font-family:Arial;padding:40px;max-width:600px;margin:0 auto;} input{width:100%;padding:10px;margin:10px 0;box-sizing:border-box;} button{padding:10px 20px;background:#ffc107;color:#333;border:none;cursor:pointer;} .error{color:red;}</style>
</head>
<body>
    <h2>✏️ Editar Proveedor</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <label>Nombre *</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($provider['nombre']) ?>" required>
        <label>Contacto</label>
        <input type="text" name="contacto" value="<?= htmlspecialchars($provider['contacto']) ?>">
        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?= htmlspecialchars($provider['telefono']) ?>">
        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($provider['email']) ?>">
        <button type="submit">Actualizar</button>
        <a href="/tp_stock/providers.php" style="margin-left:10px;">Cancelar</a>
    </form>
</body>
</html>