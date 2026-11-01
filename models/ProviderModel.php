<?php
// models/ProviderModel.php

require_once __DIR__ . '/../config/database.php';

class ProviderModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Obtener todos los proveedores
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM proveedores ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // Obtener un proveedor por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Crear un nuevo proveedor
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO proveedores (nombre, contacto, telefono, email) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$data['nombre'], $data['contacto'], $data['telefono'], $data['email']]);
    }

    // Actualizar un proveedor
    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ?, email = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'], $data['contacto'], $data['telefono'], $data['email'], $data['id']]);
    }

    // Eliminar un proveedor (Baja física)
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM proveedores WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            // Si tiene código 23000, es por la restricción de clave foránea (tiene productos asociados)
            if ($e->getCode() == 23000) {
                return 'foreign_key'; 
            }
            return false;
        }
    }
}
?>