---
name: 商品画像管理機能
about: 商品画像のアップロード・表示・管理機能の実装
title: '[FEATURE] 商品画像管理機能'
labels: ['enhancement', 'feature', 'image', 'upload', 'media']
assignees: ''
projects: ''
milestone: ''
---

## 📋 概要
プロジェクト要件に含まれている商品画像の管理・表示機能を実装します。商品マスタに画像パスが定義されているが、実際の画像アップロード・表示機能は未実装です。

## 🔍 現状
- 商品マスタテーブルに`image_path`カラムが存在
- CSVアップロードで画像パスを登録可能
- 実際の画像ファイルのアップロード機能なし
- 画像表示機能なし
- 画像ファイルの管理・保存機能なし

## 🎯 要件

### 画像アップロード機能
- [ ] 商品登録・編集時の画像アップロード
- [ ] 複数画像対応（メイン画像、サブ画像）
- [ ] 画像形式制限（JPG、PNG、GIF、WebP）
- [ ] ファイルサイズ制限（例：5MB以下）
- [ ] 画像リサイズ・最適化機能
- [ ] サムネイル生成機能

### 画像表示機能
- [ ] 商品一覧でのサムネイル表示
- [ ] 商品詳細での画像表示
- [ ] 画像ギャラリー（複数画像対応）
- [ ] 画像のズーム・拡大表示
- [ ] 画像が存在しない場合のデフォルト画像表示

### 画像管理機能
- [ ] 画像ファイルの物理保存
- [ ] 画像ファイルの削除・更新
- [ ] 画像ファイルの整理・分類
- [ ] ストレージ容量管理
- [ ] 画像のバックアップ機能

## 🛠️ 技術仕様

### ファイル構造
```
public/
├── images/
│   ├── products/
│   │   ├── original/     # オリジナル画像
│   │   ├── thumbnails/   # サムネイル画像
│   │   └── optimized/    # 最適化済み画像
│   └── default/
│       └── no-image.png  # デフォルト画像
```

### 画像処理ライブラリ
- GD Library（PHP標準）
- Imagick（オプション、高品質処理）
- 画像最適化ライブラリ

### データベース拡張
```sql
-- 商品画像テーブル（オプション）
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_type ENUM('main', 'sub') DEFAULT 'sub',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

## 📁 実装方針

### 1. 画像アップロード機能
- フォームにファイルアップロードフィールド追加
- アップロード処理の実装（UploadController拡張）
- 画像バリデーション・処理
- ファイル名の重複回避

### 2. 画像表示機能
- 商品一覧画面でのサムネイル表示
- 商品詳細画面での画像表示
- 画像ギャラリー機能
- レスポンシブ画像対応

### 3. 画像管理機能
- 画像ファイルの物理管理
- 不要画像の自動削除
- ストレージ容量監視
- 画像の最適化・圧縮

### 4. セキュリティ対策
- ファイル形式の厳密チェック
- ファイルサイズ制限
- アップロードディレクトリの保護
- 悪意のあるファイルの検出

## 📝 実装項目

### バックエンド
- [ ] `src/controllers/ImageController.php`の作成
- [ ] 画像アップロード処理の実装
- [ ] 画像リサイズ・最適化処理
- [ ] 画像削除処理
- [ ] 画像パス管理機能

### フロントエンド
- [ ] 画像アップロードUI
- [ ] 画像プレビュー機能
- [ ] ドラッグ&ドロップ対応
- [ ] 画像ギャラリー表示
- [ ] 画像ズーム機能

### データベース
- [ ] 画像テーブルの作成（オプション）
- [ ] 商品テーブルの画像パス更新
- [ ] 画像メタデータの管理

### ファイル管理
- [ ] `public/images/`ディレクトリ構造の作成
- [ ] 画像ファイルの物理保存処理
- [ ] サムネイル生成処理
- [ ] 画像最適化処理

## ⚙️ 設定・環境

### PHP設定
```ini
; php.ini設定
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
memory_limit = 256M
```

### Docker環境
- 画像保存用のボリュームマウント
- 画像処理ライブラリのインストール
- 適切なパーミッション設定

## 🧪 テスト項目
- [ ] 画像アップロード機能テスト
- [ ] 画像表示機能テスト
- [ ] 画像削除機能テスト
- [ ] 画像最適化機能テスト
- [ ] セキュリティテスト
- [ ] パフォーマンステスト

## 📚 参考資料
- [PHP GD Library](https://www.php.net/manual/en/book.image.php)
- [Image Upload Security](https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload)
- [Responsive Images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images)

## 🏷️ ラベル
- `enhancement` - 機能拡張
- `feature` - 新機能
- `image` - 画像処理
- `upload` - アップロード機能
- `media` - メディア管理

## ⚡ 優先度
**中** - プロジェクト要件の完全実装のため 