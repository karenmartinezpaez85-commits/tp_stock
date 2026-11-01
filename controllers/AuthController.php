<?php
// controllers/AuthController.php

require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Procesar el login
    public function login($email, $password) {
        // Buscar usuario por email
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            return ['success' => false, 'message' => 'Usuario no encontrado'];
        }

        // Verificar contraseña
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return ['success' => false, 'message' => 'Contraseña incorrecta'];
        }

        // Login exitoso: guardar en sesión
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_rol'] = $user['rol'];

        return ['success' => true, 'message' => 'Login exitoso'];
    }

    // Cerrar sesión
    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Sesión cerrada'];
    }

    // Verificar si hay sesión activa
    public function isLogged() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['user_id']);
    }
}
?>