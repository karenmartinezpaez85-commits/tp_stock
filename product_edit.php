<?php
// product_edit.php - Controlador para editar productos

require_once 'config/database.php';
require_once 'models/ProductModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$productModel = new ProductModel();
$error = '';
$success = '';

// 1. Obtener el ID del producto a editar (viene por URL: ?id=5)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: products.php');
    exit;
}

// 2. Obtener los datos actuales del producto
$producto = $productModel->getById($id);

if (!$producto) {
    $error = "Producto no encontrado.";
}

// Datos por defecto (si no hay producto, usamos esto para evitar errores en la vista)
$data = $producto ?: [
    'sku' => '', 'nombre' => '', 'descripcion' => '', 
    'id_categoria' => '', 'id_proveedor' => '', 
    'precio_compra' => 0, 'precio_venta' => 0, 'stock' => 0, 'stock_minimo' => 5
];

// 3. Procesar el formulario cuando se envía (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $producto) {
    // Guardar los datos del formulario
    $data = [
        'id'              => $id, // Importante para el UPDATE
        'sku'             => trim($_POST['sku']),
        'nombre'          => trim($_POST['nombre']),
        'descripcion'     => trim($_POST['descripcion']),
        'id_categoria'    => (int)$_POST['id_categoria'],
        'id_proveedor'    => (int)$_POST['id_proveedor'],
        'precio_compra'   => (float)$_POST['precio_compra'],
        'precio_venta'    => (float)$_POST['precio_venta'],
        'stock'           => (int)$_POST['stock'],
        'stock_minimo'    => (int)$_POST['stock_minimo']
    ];

    // Validaciones básicas
    if (empty($data['sku']) || empty($data['nombre']) || $data['precio_venta'] <= 0) {
        $error = "SKU, Nombre y Precio de Venta son obligatorios.";
    } else {
        // Intentar actualizar el producto
        if ($productModel->update($data)) {
            $success = "✅ Producto actualizado exitosamente.";
            // Recargar los datos actualizados para mostrarlos en el formulario
            $producto = $productModel->getById($id);
            $data = $producto;
        } else {
            $error = "❌ Error al actualizar el producto.";
        }
    }
}

// Obtener listas para los select del formulario
$categorias = $productModel->getAllCategorias();
$proveedores = $productModel->getAllProveedores();

// Incluir la vista
require_once 'views/pages/product_edit.php';
?>