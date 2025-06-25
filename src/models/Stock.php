<?php
require_once __DIR__ . '/../config/database.php';

class Stock {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DatabaseConfig::getConnection();
    }
    
    // 文字エンコーディングを正規化するメソッド
    private function normalizeEncoding($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = $this->normalizeEncoding($value);
            }
        } elseif (is_string($data)) {
            // UTF-8として正規化
            $data = mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }
        return $data;
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