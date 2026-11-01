<?php
// categories.php - Controlador de categorías

require_once 'config/database.php';
require_once 'models/CategoryModel.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /tp_stock/index.php');
    exit;
}

$categoryModel = new CategoryModel();
$categorias = $categoryModel->getAll();

// Manejar mensajes de feedback (de crear, editar o eliminar)
$feedback = '';
if (isset($_GET['msg'])) {
    if ($_GET['msg'] === 'created') $feedback = "✅ Categoría creada exitosamente.";
    elseif ($_GET['msg'] === 'updated') $feedback = "✅ Categoría actualizada exitosamente.";
    elseif ($_GET['msg'] === 'deleted') $feedback = "✅ Categoría eliminada exitosamente.";
    elseif ($_GET['msg'] === 'error_fk') $feedback = "⛔ No se puede eliminar: hay productos asociados a esta categoría.";
    elseif ($_GET['msg'] === 'error') $feedback = "❌ Ocurrió un error al procesar la solicitud.";
}

require_once 'views/pages/categories_list.php';
?>