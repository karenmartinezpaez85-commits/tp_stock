<?php
// generar_hash.php - Genera un hash válido para tu PHP

$password = '123456';
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h2>Hash generado para la contraseña '123456':</h2>";
echo "<p style='font-family: monospace; font-size: 16px; background: #f0f0f0; padding: 10px;'>$hash</p>";

// Verificar que funciona
if (password_verify($password, $hash)) {
    echo "<p style='color: green; font-weight: bold;'>✅ El hash funciona correctamente</p>";
} else {
    echo "<p style='color: red; font-weight: bold;'>❌ Error: el hash no funciona</p>";
}

echo "<hr>";
echo "<h3>Instrucciones:</h3>";
echo "<p>1. Copiá el hash de arriba (el texto largo que empieza con \$2y\$10\$)</p>";
echo "<p>2. Andá a phpMyAdmin → tabla usuarios → pestaña SQL</p>";
echo "<p>3. Pegá este código reemplazando TU_HASH_AQUI por el hash que copiaste:</p>";
echo "<pre style='background: #f0f0f0; padding: 10px;'>
UPDATE usuarios SET password = 'TU_HASH_AQUI' WHERE email = 'admin@stock.com';
UPDATE usuarios SET password = 'TU_HASH_AQUI' WHERE email = 'operador@stock.com';
</pre>";
?>