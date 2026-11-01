<?php
require_once 'config/database.php';
require_once 'models/CategoryModel.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') { 
    header('Location: /tp_stock/index.php'); exit; 
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $categoryModel = new CategoryModel();
    $result = $categoryModel->delete($id);
    
    if ($result === 'foreign_key') {
        header('Location: /tp_stock/categories.php?msg=error_fk');
    } elseif ($result) {
        header('Location: /tp_stock/categories.php?msg=deleted');
    } else {
        header('Location: /tp_stock/categories.php?msg=error');
    }
    exit;
}
header('Location: /tp_stock/categories.php');
?>