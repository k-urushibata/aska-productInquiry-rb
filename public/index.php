<?php
// エントリーポイント
session_start();

// リクエストの処理
$action = $_GET['action'] ?? 'search';

// 適切なコントローラーとビューを読み込み
switch ($action) {
    case 'search':
        require_once '../src/controllers/InventoryController.php';
        require_once '../src/views/inventory_search.php';
        break;
        
    case 'upload':
        require_once '../src/controllers/UploadController.php';
        require_once '../src/views/upload_csv.php';
        break;
        
    default:
        // デフォルトは検索画面
        require_once '../src/controllers/InventoryController.php';
        require_once '../src/views/inventory_search.php';
        break;
}
?> 