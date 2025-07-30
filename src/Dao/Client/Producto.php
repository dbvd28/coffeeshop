<?php
namespace DAO;

use PDO;
use PDOException;

class Product {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getActiveProducts() {
        $sql = "SELECT productId, productName, productDescription, productPrice, productImgUrl, productStock 
                FROM productos 
                WHERE productStatus = 'ACT' AND productStock > 0";
        try {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejo de error
            return [];
        }
    }
}
