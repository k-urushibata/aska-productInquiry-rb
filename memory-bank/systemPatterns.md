# systemPatterns.md

## システムアーキテクチャ
- LAMP構成（Linux, Apache, MySQL, PHP）を想定
- WebフロントエンドはシンプルなHTML+PHP

## 主要な技術的決定
- DBアクセスはPDOを利用
- データ一括登録はCSVファイルアップロード

## 使用デザインパターン
- DBテーブル分割（商品情報と在庫情報の分離）
- SQLのJOINによるデータ集約

## コンポーネント間の関係
- m_product（商品マスタ）: 商品情報を管理
- t_stock（在庫テーブル）: 商品IDごとの在庫数を管理
- inventory_search.php: 検索・一覧表示
- upload_csv.php: データ一括登録

## 重要な実装経路
- CSV→upload_csv.php→DB登録/更新
- inventory_search.php→DB検索→HTML表示 