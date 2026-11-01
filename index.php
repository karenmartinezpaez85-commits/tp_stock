<?php
// index.php - Punto de entrada del sistema

require_once 'controllers/AuthController.php';

$auth = new AuthController();

// Si ya está logueado, redirigir al dashboard
if ($auth->isLogged()) {
    header('Location: views/pages/dashboard.php');
    exit;
}

// Procesar el formulario de login
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    $resultado = $auth->login($email, $password);
    
    if ($resultado['success']) {
        header('Location: views/pages/dashboard.php');
        exit;
    } else {
        $error = $resultado['message'];
    }
}

// Mostrar formulario de login
require_once 'views/pages/login.php';
?>