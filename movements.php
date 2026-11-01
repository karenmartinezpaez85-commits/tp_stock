<?php
// movements.php - Controlador del listado de movimientos

require_once 'config/database.php';
require_once 'models/MovementModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /tp_stock/index.php');
    exit;
}

$movementModel = new MovementModel();
$movimientos = $movementModel->getAll();

// Manejar mensajes de feedback
$feedback = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $feedback = "✅ Movimiento registrado exitosamente. El stock se actualizó automáticamente.";
    elseif ($_GET['msg'] === 'error') $feedback = "❌ Ocurrió un error al registrar el movimiento.";
}

require_once 'views/pages/movements_list.php';
?>