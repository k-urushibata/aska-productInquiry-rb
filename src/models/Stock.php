<?php
require_once __DIR__ . '/../config/database.php';

class Stock {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DatabaseConfig::getConnection();
    }
    
    // 在庫登録・更新
    public function upsertStock($productId, $quantity) {
        $sql = "INSERT INTO t_stock (product_id, quantity)
                VALUES (:id, :qty)
                ON DUPLICATE KEY UPDATE quantity = :qty";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $productId,
            ':qty' => $quantity
        ]);
    }
    
    // 在庫登録（新規）
    public function createStock($productId, $quantity) {
        $sql = "INSERT INTO t_stock (product_id, quantity) VALUES (:id, :qty)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $productId,
            ':qty' => $quantity
        ]);
    }
}
?> 