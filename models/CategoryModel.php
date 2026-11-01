<?php
// models/CategoryModel.php

require_once __DIR__ . '/../config/database.php';

class CategoryModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Obtener todas las categorías
    public function getAll() {
        $stmt = $this->conn->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // Obtener una categoría por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Crear una nueva categoría
    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)");
        return $stmt->execute([$data['nombre'], $data['descripcion']]);
    }

    // Actualizar una categoría
    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?");
        return $stmt->execute([$data['nombre'], $data['descripcion'], $data['id']]);
    }

    // Eliminar una categoría (Baja física)
    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM categorias WHERE id = ?");
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