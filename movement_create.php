<?php
// movement_create.php - Controlador para registrar movimientos

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
$error = '';

// Obtener la lista de productos para el desplegable del formulario
$productos = $productModel->getAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitizar y validar datos
    $data = [
        'id_producto'   => (int)$_POST['id_producto'],
        'tipo'          => $_POST['tipo'],
        'cantidad'      => (int)$_POST['cantidad'],
        'observaciones' => trim($_POST['observaciones']),
        'id_usuario'    => $_SESSION['user_id'] // El usuario logueado
    ];

    // 2. Validación de Stock (Muy importante para las "Salidas")
    if ($data['tipo'] === 'salida') {
        $productoActual = $productModel->getById($data['id_producto']);
        if ($productoActual && $productoActual['stock'] < $data['cantidad']) {
            $error = "⛔ Stock insuficiente. El stock actual es: " . $productoActual['stock'];
        }
    }

    if ($data['cantidad'] <= 0) {
        $error = "La cantidad debe ser mayor a 0.";
    }

    // 3. Si no hay errores, intentar crear el movimiento (con transacción)
    if (empty($error)) {
        if ($movementModel->create($data)) {
            // Redirigir al listado de movimientos (que haremos en el paso 3)
            header('Location: /tp_stock/movements.php?msg=created');
            exit;
        } else {
            $error = "❌ Error al registrar el movimiento. Intentalo de nuevo.";
        }
    }
}

// Incluir la vista
require_once 'views/pages/movement_create.php';
?>