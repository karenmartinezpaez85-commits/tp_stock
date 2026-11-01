<?php
// dashboard.php - Punto de entrada al dashboard
// Verifica sesión y muestra la vista

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Incluir la vista real
require_once 'views/pages/dashboard.php';
?>