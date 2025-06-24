<?php
require_once __DIR__ . '/../models/Product.php';

class InventoryController {
    private $productModel;
    
    public function __construct() {
        $this->productModel = new Product();
    }
    
    // 在庫検索処理
    public function searchInventory($productName = '', $manufacturerName = '') {
        try {
            return $this->productModel->searchProducts($productName, $manufacturerName);
        } catch (Exception $e) {
            throw new Exception("検索処理でエラーが発生しました: " . $e->getMessage());
        }
    }
    
    // 検索条件の取得
    public function getSearchConditions() {
        return [
            'product_name' => $_POST['product_name'] ?? '',
            'manufacturer_name' => $_POST['manufacturer_name'] ?? ''
        ];
    }
}
?> 