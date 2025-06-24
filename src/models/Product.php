<?php
require_once __DIR__ . '/../config/database.php';

class Product {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DatabaseConfig::getConnection();
    }
    
    // 商品検索
    public function searchProducts($productName = '', $manufacturerName = '') {
        $sql = "SELECT 
                    p.id,
                    p.product_name,
                    p.product_code,
                    p.price,
                    p.manufacturer_name,
                    p.image_path,
                    s.quantity
                FROM m_product p
                JOIN t_stock s ON p.id = s.product_id
                WHERE p.product_name LIKE :product_name
                  AND p.manufacturer_name LIKE :manufacturer_name";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':product_name' => '%' . $productName . '%',
            ':manufacturer_name' => '%' . $manufacturerName . '%'
        ]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // 商品登録
    public function createProduct($productName, $productCode, $price, $manufacturerName, $imagePath = null) {
        $sql = "INSERT INTO m_product (product_name, product_code, price, manufacturer_name, image_path)
                VALUES (:name, :code, :price, :maker, :image)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $productName,
            ':code' => $productCode,
            ':price' => $price,
            ':maker' => $manufacturerName,
            ':image' => $imagePath
        ]);
        
        return $this->pdo->lastInsertId();
    }
    
    // 既存商品チェック
    public function findProductByNameAndMaker($productName, $manufacturerName) {
        $sql = "SELECT id FROM m_product WHERE product_name = :name AND manufacturer_name = :maker";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':name' => $productName,
            ':maker' => $manufacturerName
        ]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?> 