<?php
require_once 'config/database.php';
require_once 'models/ProviderModel.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'admin') { 
    header('Location: /tp_stock/index.php'); exit; 
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $providerModel = new ProviderModel();
    $result = $providerModel->delete($id);
    
    if ($result === 'foreign_key') {
        header('Location: /tp_stock/providers.php?msg=error_fk');
    } elseif ($result) {
        header('Location: /tp_stock/providers.php?msg=deleted');
    } else {
        header('Location: /tp_stock/providers.php?msg=error');
    }
    exit;
}
header('Location: /tp_stock/providers.php');
?>