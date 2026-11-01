<?php
// models/MovementModel.php

require_once __DIR__ . '/../config/database.php';

class MovementModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Crear un movimiento y actualizar stock (USANDO TRANSACCIONES)
    public function create($data) {
        // 1. Iniciamos la transacción (BEGIN)
        $this->conn->beginTransaction();

        try {
            // 2. Insertar el registro en la tabla movimientos
            $stmtMov = $this->conn->prepare("
                INSERT INTO movimientos (id_producto, id_usuario, tipo, cantidad, observaciones)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmtMov->execute([
                $data['id_producto'],
                $data['id_usuario'],
                $data['tipo'],
                $data['cantidad'],
                $data['observaciones']
            ]);

            // 3. Actualizar el stock en la tabla productos según el tipo
            $stmtStock = null;
            
            if ($data['tipo'] === 'entrada') {
                // Si es entrada, SUMAMOS la cantidad
                $stmtStock = $this->conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
            } elseif ($data['tipo'] === 'salida') {
                // Si es salida, RESTAMOS la cantidad
                $stmtStock = $this->conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            } elseif ($data['tipo'] === 'ajuste') {
                // Si es ajuste, SUMAMOS (el usuario puede poner número negativo si quiere restar)
                $stmtStock = $this->conn->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
            }

            if ($stmtStock) {
                $stmtStock->execute([$data['cantidad'], $data['id_producto']]);
            }

            // 4. Si todo salió bien, confirmamos los cambios (COMMIT)
            $this->conn->commit();
            return true;

        } catch (PDOException $e) {
            // 5. Si algo falló, deshacemos TODO (ROLLBACK)
            $this->conn->rollBack();
            
            // Guardamos el error en el log de PHP para debugging
            error_log("Error en transacción de movimiento: " . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los movimientos (para el listado y reportes futuros)
    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT m.*, p.nombre as producto, u.nombre as usuario
            FROM movimientos m
            LEFT JOIN productos p ON m.id_producto = p.id
            LEFT JOIN usuarios u ON m.id_usuario = u.id
            ORDER BY m.fecha DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }
        // Obtener movimientos con filtros avanzados
    public function getFiltered($filters = []) {
        $sql = "
            SELECT m.*, p.nombre as producto, p.sku, u.nombre as usuario
            FROM movimientos m
            LEFT JOIN productos p ON m.id_producto = p.id
            LEFT JOIN usuarios u ON m.id_usuario = u.id
            WHERE 1=1
        ";
        
        $params = [];
        
        // Filtro por fecha desde
        if (!empty($filters['fecha_desde'])) {
            $sql .= " AND m.fecha >= ?";
            $params[] = $filters['fecha_desde'] . ' 00:00:00';
        }
        
        // Filtro por fecha hasta
        if (!empty($filters['fecha_hasta'])) {
            $sql .= " AND m.fecha <= ?";
            $params[] = $filters['fecha_hasta'] . ' 23:59:59';
        }
        
        // Filtro por tipo
        if (!empty($filters['tipo']) && $filters['tipo'] !== 'todos') {
            $sql .= " AND m.tipo = ?";
            $params[] = $filters['tipo'];
        }
        
        // Filtro por producto
        if (!empty($filters['id_producto'])) {
            $sql .= " AND m.id_producto = ?";
            $params[] = $filters['id_producto'];
        }
        
        // Filtro por usuario
        if (!empty($filters['id_usuario'])) {
            $sql .= " AND m.id_usuario = ?";
            $params[] = $filters['id_usuario'];
        }
        
        $sql .= " ORDER BY m.fecha DESC";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Obtener resumen estadístico de movimientos
    public function getSummary($filters = []) {
        $sql = "
            SELECT 
                COUNT(*) as total_movimientos,
                SUM(CASE WHEN tipo = 'entrada' THEN cantidad ELSE 0 END) as total_entradas,
                SUM(CASE WHEN tipo = 'salida' THEN cantidad ELSE 0 END) as total_salidas,
                SUM(CASE WHEN tipo = 'ajuste' THEN cantidad ELSE 0 END) as total_ajustes
            FROM movimientos
            WHERE 1=1
        ";
        
        $params = [];
        
        if (!empty($filters['fecha_desde'])) {
            $sql .= " AND fecha >= ?";
            $params[] = $filters['fecha_desde'] . ' 00:00:00';
        }
        if (!empty($filters['fecha_hasta'])) {
            $sql .= " AND fecha <= ?";
            $params[] = $filters['fecha_hasta'] . ' 23:59:59';
        }
        if (!empty($filters['tipo']) && $filters['tipo'] !== 'todos') {
            $sql .= " AND tipo = ?";
            $params[] = $filters['tipo'];
        }
        if (!empty($filters['id_producto'])) {
            $sql .= " AND id_producto = ?";
            $params[] = $filters['id_producto'];
        }
        if (!empty($filters['id_usuario'])) {
            $sql .= " AND id_usuario = ?";
            $params[] = $filters['id_usuario'];
        }
        
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }
}
?>