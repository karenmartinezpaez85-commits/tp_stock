<?php
// products.php - Controlador de productos

require_once 'config/database.php';
require_once 'models/ProductModel.php';

// Verificar que esté logueado
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$productModel = new ProductModel();

// Procesar búsqueda
$searchTerm = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    $productos = $productModel->search($searchTerm);
} else {
    $productos = $productModel->getAll();
}

// Obtener productos con stock bajo (para alertas)
$lowStockProducts = $productModel->getLowStockProducts();

// Manejar mensajes de feedback
$feedback = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'deleted') {
        $feedback = "✅ Producto dado de baja correctamente.";
    } elseif ($_GET['msg'] === 'error') {
        $feedback = "❌ Error al dar de baja el producto.";
    } elseif ($_GET['msg'] === 'permisos') {
        $feedback = "⛔ No tenés permisos para realizar esta acción.";
    }
}
// Incluir la vista
require_once 'views/pages/products_list.php';
?>