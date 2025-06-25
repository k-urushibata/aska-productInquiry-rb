<?php
require_once __DIR__ . '/../controllers/InquiryController.php';

$inquiryController = new InquiryController();
$message = '';
$productInfo = null;

// GETパラメータがあれば必ず初期値に反映
$productInfo = [
    'product_name' => $_GET['product_name'] ?? '',
    'product_code' => $_GET['product_code'] ?? '',
    'manufacturer_name' => $_GET['manufacturer_name'] ?? '',
    'price' => $_GET['price'] ?? '',
    'quantity' => $_GET['quantity'] ?? ''
];

// 商品コードが指定されている場合、DBから取得した情報で上書き
if (!empty($_GET['product_code'])) {
    $dbProductInfo = $inquiryController->getProductInfo($_GET['product_code']);
    if ($dbProductInfo) {
        $productInfo = array_merge($productInfo, $dbProductInfo);
    }
}

// フォーム送信処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inquiryData = [
        'customer_name' => $_POST['customer_name'] ?? '',
        'customer_email' => $_POST['customer_email'] ?? '',
        'customer_phone' => $_POST['customer_phone'] ?? '',
        'inquiry_content' => $_POST['inquiry_content'] ?? '',
        'product_name' => $_POST['product_name'] ?? '',
        'product_code' => $_POST['product_code'] ?? '',
        'manufacturer_name' => $_POST['manufacturer_name'] ?? '',
        'price' => $_POST['price'] ?? '',
        'quantity' => $_POST['quantity'] ?? ''
    ];
    
    $result = $inquiryController->sendInquiry($inquiryData);
    $message = $result['message'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>商品問い合わせ</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .form-container { background: #f8f9fa; padding: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        .form-group textarea { height: 100px; resize: vertical; }
        .product-info { background: #e9ecef; padding: 15px; border-radius: 3px; margin-bottom: 20px; }
        .product-info h3 { margin-top: 0; }
        .product-info p { margin: 5px 0; }
        .btn { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .btn:hover { background: #0056b3; }
        .btn-secondary { background: #6c757d; }
        .btn-secondary:hover { background: #545b62; }
        .message { padding: 10px; border-radius: 3px; margin-bottom: 15px; }
        .message.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .message.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .required { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>商品問い合わせ</h1>
        
        <div class="nav">
            <a href="?action=search">在庫検索</a>
            <a href="?action=upload">CSVアップロード</a>
        </div>

        <?php if ($message): ?>
            <div class="message <?= strpos($message, '送信しました') !== false ? 'success' : 'error' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post">
                <!-- 商品情報（自動入力） -->
                <?php if ($productInfo): ?>
                    <div class="product-info">
                        <h3>問い合わせ商品</h3>
                        <p><strong>商品名:</strong> <?= htmlspecialchars($productInfo['product_name']) ?></p>
                        <p><strong>商品コード:</strong> <?= htmlspecialchars($productInfo['product_code']) ?></p>
                        <p><strong>メーカー:</strong> <?= htmlspecialchars($productInfo['manufacturer_name']) ?></p>
                        <p><strong>価格:</strong> <?= htmlspecialchars($productInfo['price']) ?> 円</p>
                        <p><strong>在庫数:</strong> <?= htmlspecialchars($productInfo['quantity']) ?></p>
                        
                        <!-- 隠しフィールドで商品情報を送信 -->
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($productInfo['product_name']) ?>">
                        <input type="hidden" name="product_code" value="<?= htmlspecialchars($productInfo['product_code']) ?>">
                        <input type="hidden" name="manufacturer_name" value="<?= htmlspecialchars($productInfo['manufacturer_name']) ?>">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($productInfo['price']) ?>">
                        <input type="hidden" name="quantity" value="<?= htmlspecialchars($productInfo['quantity']) ?>">
                    </div>
                <?php else: ?>
                    <!-- 商品情報が取得できない場合の手動入力 -->
                    <div class="form-group">
                        <label>商品名 <span class="required">*</span></label>
                        <input type="text" name="product_name" value="<?= htmlspecialchars($productInfo['product_name'] ?? ($_POST['product_name'] ?? '')) ?>" required>
                    </div>
                    <div class="form-group">
                        <label>商品コード</label>
                        <input type="text" name="product_code" value="<?= htmlspecialchars($productInfo['product_code'] ?? ($_POST['product_code'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label>メーカー</label>
                        <input type="text" name="manufacturer_name" value="<?= htmlspecialchars($productInfo['manufacturer_name'] ?? ($_POST['manufacturer_name'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label>価格</label>
                        <input type="text" name="price" value="<?= htmlspecialchars($productInfo['price'] ?? ($_POST['price'] ?? '')) ?>">
                    </div>
                    <div class="form-group">
                        <label>在庫数</label>
                        <input type="text" name="quantity" value="<?= htmlspecialchars($productInfo['quantity'] ?? ($_POST['quantity'] ?? '')) ?>">
                    </div>
                <?php endif; ?>

                <!-- お客様情報 -->
                <h3>お客様情報</h3>
                <div class="form-group">
                    <label>お名前 <span class="required">*</span></label>
                    <input type="text" name="customer_name" value="<?= htmlspecialchars($_POST['customer_name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>メールアドレス <span class="required">*</span></label>
                    <input type="email" name="customer_email" value="<?= htmlspecialchars($_POST['customer_email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>電話番号 <span class="required">*</span></label>
                    <input type="tel" name="customer_phone" value="<?= htmlspecialchars($_POST['customer_phone'] ?? '') ?>" required>
                </div>

                <!-- 問い合わせ内容 -->
                <h3>問い合わせ内容</h3>
                <div class="form-group">
                    <label>お問い合わせ内容 <span class="required">*</span></label>
                    <textarea name="inquiry_content" required placeholder="商品についてのご質問やご要望をお聞かせください。"><?= htmlspecialchars($_POST['inquiry_content'] ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn">問い合わせを送信</button>
                    <a href="?action=search" class="btn btn-secondary">検索に戻る</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 