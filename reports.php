<?php
// reports.php - Controlador de reportes y estadísticas

require_once 'config/database.php';
require_once 'models/MovementModel.php';
require_once 'models/ProductModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /tp_stock/index.php');
    exit;
}

$movementModel = new MovementModel();
$productModel = new ProductModel();

// Obtener listas para los filtros
$productos = $productModel->getAll();

// Filtros por defecto (últimos 30 días)
$filters = [
    'fecha_desde' => date('Y-m-d', strtotime('-30 days')),
    'fecha_hasta' => date('Y-m-d'),
    'tipo' => 'todos',
    'id_producto' => '',
    'id_usuario' => ''
];

// Procesar formulario de filtros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filters = [
        'fecha_desde' => $_POST['fecha_desde'] ?? '',
        'fecha_hasta' => $_POST['fecha_hasta'] ?? '',
        'tipo' => $_POST['tipo'] ?? 'todos',
        'id_producto' => $_POST['id_producto'] ?? '',
        'id_usuario' => $_POST['id_usuario'] ?? ''
    ];
}

// Obtener datos filtrados
$movimientos = $movementModel->getFiltered($filters);
$resumen = $movementModel->getSummary($filters);

require_once 'views/pages/reports.php';
?>