<?php
require_once 'config/database.php';
require_once 'models/ProviderModel.php';

session_start();
if (!isset($_SESSION['user_id'])) { header('Location: /tp_stock/index.php'); exit; }

$providerModel = new ProviderModel();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nombre'    => trim($_POST['nombre']),
        'contacto'  => trim($_POST['contacto']),
        'telefono'  => trim($_POST['telefono']),
        'email'     => trim($_POST['email'])
    ];
    if (empty($data['nombre'])) {
        $error = "El nombre del proveedor es obligatorio.";
    } elseif ($providerModel->create($data)) {
        header('Location: /tp_stock/providers.php?msg=created');
        exit;
    } else {
        $error = "Error al crear el proveedor.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Nuevo Proveedor</title>
    <style>body{font-family:Arial;padding:40px;max-width:600px;margin:0 auto;} input{width:100%;padding:10px;margin:10px 0;box-sizing:border-box;} button{padding:10px 20px;background:#28a745;color:white;border:none;cursor:pointer;} .error{color:red;}</style>
</head>
<body>
    <h2>➕ Nuevo Proveedor</h2>
    <?php if($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
    <form method="POST">
        <label>Nombre *</label>
        <input type="text" name="nombre" required>
        <label>Contacto</label>
        <input type="text" name="contacto">
        <label>Teléfono</label>
        <input type="text" name="telefono">
        <label>Email</label>
        <input type="email" name="email">
        <button type="submit">Guardar</button>
        <a href="/tp_stock/providers.php" style="margin-left:10px;">Cancelar</a>
    </form>
</body>
</html>