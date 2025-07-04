<?php
// コントローラーを使用した検索処理
$controller = new InventoryController();
$conditions = $controller->getSearchConditions();

try {
    $results = $controller->searchInventory($conditions['product_name'], $conditions['manufacturer_name']);
} catch (Exception $e) {
    $error = $e->getMessage();
    $results = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>在庫照会</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .search-form { background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px; }
        .search-form input[type="text"] { padding: 8px; margin-right: 10px; width: 200px; }
        .search-form button { padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer; }
        .search-form button:hover { background: #0056b3; }
        .error { color: red; margin: 10px 0; }
        img { max-width: 100px; }
        .btn-inquiry { padding: 6px 12px; background: #28a745; color: white; border: none; border-radius: 3px; cursor: pointer; text-decoration: none; font-size: 12px; }
        .btn-inquiry:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>在庫照会</h1>
        
        <div class="nav">
            <a href="?action=search">在庫検索</a>
            <a href="?action=upload">CSVアップロード</a>
        </div>

        <div class="search-form">
            <form method="post">
                商品名: <input type="text" name="product_name" value="<?= htmlspecialchars($conditions['product_name']) ?>">
                メーカ名: <input type="text" name="manufacturer_name" value="<?= htmlspecialchars($conditions['manufacturer_name']) ?>">
                <button type="submit">検索</button>
            </form>
        </div>

        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($results): ?>
            <table>
                <tr>
                    <th>商品コード</th>
                    <th>商品名</th>
                    <th>メーカ名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th></th>
                </tr>
                <?php foreach ($results as $row): ?>
                    <tr>
                        <td><?= $row['product_code'] !== null ? htmlspecialchars($row['product_code']) : '' ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['manufacturer_name']) ?></td>
                        <td><?= htmlspecialchars($row['price']) ?> 円</td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td>
                            <a href="?action=inquiry&product_code=<?= urlencode($row['product_code']) ?>&product_name=<?= urlencode($row['product_name']) ?>&manufacturer_name=<?= urlencode($row['manufacturer_name']) ?>&price=<?= urlencode($row['price']) ?>&quantity=<?= urlencode($row['quantity']) ?>" class="btn-inquiry">問い合わせ</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (!isset($error)): ?>
            <p>該当する商品が見つかりませんでした。</p>
        <?php endif; ?>
    </div>
</body>
</html>
