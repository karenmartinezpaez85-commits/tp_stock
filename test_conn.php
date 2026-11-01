<?php
require_once 'config/database.php';

$db = new Database();
$conn = $db->getConnection();

if ($conn) {
    echo "✅ Conexión exitosa a la base de datos 'sistemas_stock'<br><br>";
    
    // Probar una consulta simple
    $stmt = $conn->query("SELECT COUNT(*) as total FROM productos");
    $resultado = $stmt->fetch();
    echo "📦 Total de productos en la BD: " . $resultado['total'] . "<br>";
    
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuarios");
    $resultado = $stmt->fetch();
    echo "👥 Total de usuarios: " . $resultado['total'];
} else {
    echo "❌ Error de conexión";
}
?>