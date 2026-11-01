<?php
// providers.php - Controlador de proveedores

require_once 'config/database.php';
require_once 'models/ProviderModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /tp_stock/index.php');
    exit;
}

$providerModel = new ProviderModel();
$proveedores = $providerModel->getAll();

// Manejar mensajes de feedback
$feedback = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $feedback = "✅ Proveedor creado exitosamente.";
    elseif ($_GET['msg'] === 'updated') $feedback = "✅ Proveedor actualizado exitosamente.";
    elseif ($_GET['msg'] === 'deleted') $feedback = "✅ Proveedor eliminado exitosamente.";
    elseif ($_GET['msg'] === 'error_fk') $feedback = "⛔ No se puede eliminar: hay productos asociados a este proveedor.";
    elseif ($_GET['msg'] === 'error') $feedback = "❌ Ocurrió un error al procesar la solicitud.";
}

require_once 'views/pages/providers_list.php';
?>