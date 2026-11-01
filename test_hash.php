<?php
// test_hash.php - Verificar que el hash funciona

$contrasenia = '123456';
$hash = '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy';

if (password_verify($contrasenia, $hash)) {
    echo "✅ El hash ES válido para la contraseña '123456'";
} else {
    echo "❌ El hash NO es válido";
}
?>