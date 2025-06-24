<?php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Stock.php';

class UploadController {
    private $productModel;
    private $stockModel;
    
    public function __construct() {
        $this->productModel = new Product();
        $this->stockModel = new Stock();
    }
    
    // CSVファイル処理
    public function processCsvFile($filePath) {
        if (($handle = fopen($filePath, "r")) === FALSE) {
            throw new Exception("CSVファイルを開けませんでした。");
        }
        
        try {
            // ヘッダーを読み飛ばす
            fgetcsv($handle, 200, ",", '"', "\\");
            
            $processedCount = 0;
            while (($data = fgetcsv($handle, 200, ",", '"', "\\")) !== FALSE) {
                $this->processCsvRow($data);
                $processedCount++;
            }
            
            fclose($handle);
            return $processedCount;
            
        } catch (Exception $e) {
            fclose($handle);
            throw $e;
        }
    }
    
    // CSV行処理
    private function processCsvRow($data) {
        $productName = trim($data[0]);
        $productCode = isset($data[1]) && trim($data[1]) !== '' ? trim($data[1]) : '';
        $price = isset($data[2]) ? (int)trim($data[2]) : 0;
        $manufacturerName = trim($data[3]);
        $quantity = isset($data[4]) ? (int)trim($data[4]) : 0;
        
        if (!$productName || !$manufacturerName) {
            return; // スキップ
        }
        
        // 既存商品のチェック
        $existingProduct = $this->productModel->findProductByNameAndMaker($productName, $manufacturerName);
        
        if ($existingProduct) {
            // 既存 → 在庫を更新
            $this->stockModel->upsertStock($existingProduct['id'], $quantity);
        } else {
            // 新規商品登録
            $newProductId = $this->productModel->createProduct($productName, $productCode, $price, $manufacturerName);
            $this->stockModel->createStock($newProductId, $quantity);
        }
    }
}
?> 