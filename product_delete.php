<?php
// product_delete.php - Controlador para dar de baja productos

require_once 'config/database.php';
require_once 'models/ProductModel.php';

session_start();

// 1. Seguridad: Verificar que esté logueado y sea admin
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

if ($_SESSION['user_rol'] !== 'admin') {
    // Si no es admin, no puede dar de baja
    header('Location: products.php?error=permisos');
    exit;
}

// 2. Obtener el ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $productModel = new ProductModel();
    
    // Ejecutar la baja lógica
    if ($productModel->deactivate($id)) {
        header('Location: products.php?msg=deleted');
    } else {
        header('Location: products.php?msg=error');
    }
    exit;
}

// Si no hay ID, volver al listado
header('Location: products.php');
exit;
?>