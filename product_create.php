<?php
// product_create.php - Controlador para crear productos

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

// Datos por defecto para el formulario
$data = [
    'sku' => '',
    'nombre' => '',
    'descripcion' => '',
    'id_categoria' => '',
    'id_proveedor' => '',
    'precio_compra' => 0,
    'precio_venta' => 0,
    'stock' => 0,
    'stock_minimo' => 5
];

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar los datos del formulario
    $data = [
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
        // Intentar crear el producto
        if ($productModel->create($data)) {
            $success = "✅ Producto creado exitosamente.";
            // Limpiar el formulario
            $data = [
                'sku' => '',
                'nombre' => '',
                'descripcion' => '',
                'id_categoria' => '',
                'id_proveedor' => '',
                'precio_compra' => 0,
                'precio_venta' => 0,
                'stock' => 0,
                'stock_minimo' => 5
            ];
        } else {
            $error = "❌ Error al crear el producto. ¿El SKU ya existe?";
        }
    }
}

// Obtener listas para los select del formulario
$categorias = $productModel->getAllCategorias();
$proveedores = $productModel->getAllProveedores();

// Incluir la vista
require_once 'views/pages/product_create.php';
?>