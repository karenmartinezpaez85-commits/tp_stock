<?php
// models/ProductModel.php

require_once __DIR__ . '/../config/database.php';

class ProductModel {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    // Obtener todos los productos activos
    public function getAll() {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre as categoria, pr.nombre as proveedor
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            LEFT JOIN proveedores pr ON p.id_proveedor = pr.id
            WHERE p.activo = 1
            ORDER BY p.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Buscar productos por nombre, SKU o categoría
    public function search($term) {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre as categoria, pr.nombre as proveedor
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            LEFT JOIN proveedores pr ON p.id_proveedor = pr.id
            WHERE p.activo = 1 
            AND (p.nombre LIKE ? OR p.sku LIKE ? OR c.nombre LIKE ?)
            ORDER BY p.id DESC
        ");
        $searchTerm = "%$term%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }

    // Obtener un producto por ID
    public function getById($id) {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre as categoria, pr.nombre as proveedor
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            LEFT JOIN proveedores pr ON p.id_proveedor = pr.id
            WHERE p.id = ? AND p.activo = 1
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Verificar si el stock está bajo el mínimo
    public function getLowStockProducts() {
        $stmt = $this->conn->prepare("
            SELECT p.*, c.nombre as categoria
            FROM productos p
            LEFT JOIN categorias c ON p.id_categoria = c.id
            WHERE p.activo = 1 AND p.stock <= p.stock_minimo
            ORDER BY p.stock ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

        // Crear un nuevo producto
    public function create($data) {
        try {
            $stmt = $this->conn->prepare("
                INSERT INTO productos (sku, nombre, descripcion, id_categoria, id_proveedor, precio_compra, precio_venta, stock, stock_minimo, activo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
            ");
            
            return $stmt->execute([
                $data['sku'],
                $data['nombre'],
                $data['descripcion'],
                $data['id_categoria'],
                $data['id_proveedor'],
                $data['precio_compra'],
                $data['precio_venta'],
                $data['stock'],
                $data['stock_minimo']
            ]);
        } catch (PDOException $e) {
            // Si el error es por duplicado (código 23000), retornamos false para que el controlador muestre el error
            if ($e->getCode() == 23000) {
                return false; 
            }
            // Si es otro error, lo mostramos
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Obtener todas las categorías (para el formulario)
    public function getAllCategorias() {
        $stmt = $this->conn->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // Obtener todos los proveedores (para el formulario)
    public function getAllProveedores() {
        $stmt = $this->conn->query("SELECT id, nombre FROM proveedores ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }
        // Actualizar un producto existente
    public function update($data) {
        $stmt = $this->conn->prepare("
            UPDATE productos 
            SET sku = ?, nombre = ?, descripcion = ?, id_categoria = ?, id_proveedor = ?, 
                precio_compra = ?, precio_venta = ?, stock = ?, stock_minimo = ?
            WHERE id = ?
        ");
        
        return $stmt->execute([
            $data['sku'],
            $data['nombre'],
            $data['descripcion'],
            $data['id_categoria'],
            $data['id_proveedor'],
            $data['precio_compra'],
            $data['precio_venta'],
            $data['stock'],
            $data['stock_minimo'],
            $data['id'] // El ID es necesario para el WHERE
        ]);
    }
        // Dar de baja un producto (Baja Lógica)
    public function deactivate($id) {
        $stmt = $this->conn->prepare("UPDATE productos SET activo = 0 WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>