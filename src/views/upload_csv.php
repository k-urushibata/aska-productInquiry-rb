<?php
// コントローラーを使用したCSVアップロード処理
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    try {
        $controller = new UploadController();
        $file = $_FILES['csv_file']['tmp_name'];
        
        if (!is_uploaded_file($file)) {
            throw new Exception("ファイルのアップロードに失敗しました。");
        }
        
        $processedCount = $controller->processCsvFile($file);
        $message = "CSVの取り込みが完了しました。処理件数: {$processedCount}件";
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSVアップロード</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .upload-form { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .upload-form input[type="file"] { margin: 10px 0; }
        .upload-form button { padding: 8px 16px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .upload-form button:hover { background: #218838; }
        .message { color: green; margin: 10px 0; padding: 10px; background: #d4edda; border-radius: 3px; }
        .error { color: red; margin: 10px 0; padding: 10px; background: #f8d7da; border-radius: 3px; }
        .info { background: #d1ecf1; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>商品在庫CSVアップロード</h1>
        
        <div class="nav">
            <a href="?action=search">在庫検索</a>
            <a href="?action=upload">CSVアップロード</a>
        </div>

        <div class="info">
            <h3>CSVファイル形式</h3>
            <p>以下の形式でCSVファイルを準備してください：</p>
            <ul>
                <li>1列目: 商品名（必須）</li>
                <li>2列目: 商品コード（任意）</li>
                <li>3列目: 価格（数値）</li>
                <li>4列目: メーカ名（必須）</li>
                <li>5列目: 在庫数（数値）</li>
            </ul>
            <p>※ 1行目はヘッダー行として扱われます</p>
        </div>

        <div class="upload-form">
            <form method="post" enctype="multipart/form-data">
                CSVファイルを選択: <input type="file" name="csv_file" accept=".csv" required>
                <br>
                <button type="submit">アップロード</button>
            </form>
        </div>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
