# 商品在庫管理・検索システム

## 概要
商品情報と在庫数を一元管理し、検索・更新できるWebシステムです。

## 機能
- 商品マスタ管理（商品名、商品コード、価格、メーカ名、画像パス）
- 在庫管理（商品ID、在庫数）
- CSV一括登録・更新
- 商品名・メーカ名での部分一致検索
- 商品情報と在庫数の一覧表示
- 問い合わせ機能（PHPMailer + MailHog）

## 技術スタック
- **バックエンド**: PHP 8.1+
- **データベース**: MySQL 8.0+
- **フロントエンド**: HTML, CSS, JavaScript
- **開発環境**: Docker（LAMP + MailHog）
- **本番環境**: XAMPP
- **メール送信**: PHPMailer + SMTP

## プロジェクト構造
```
aska-productInquiry-rb/
├── memory-bank/          # プロジェクトドキュメント
├── src/                  # PHPソースコード（MVC）
│   ├── config/          # データベース・メール設定
│   ├── controllers/     # コントローラー
│   ├── models/          # モデル
│   └── views/           # ビュー
├── public/              # Web公開ディレクトリ
├── database/            # データベース関連
│   ├── schema/          # スキーマ定義（自動初期化）
│   └── data/            # サンプルデータ
├── docker/              # Docker設定
└── README.md            # プロジェクト説明
```

## セットアップ

### Docker環境（推奨）

#### Docker Compose操作コマンド
```bash
cd docker

# Docker Composeを起動
docker-compose up -d

# Docker Composeを停止（データ保持）
docker-compose down

# Docker Composeを停止（データ含めて削除）
docker-compose down -v
```

#### 初回セットアップ
1. DockerとDocker Composeをインストール
2. プロジェクトルートで以下のコマンドを実行：
   ```bash
   cd docker
   docker-compose up -d
   ```
3. 自動的に以下が実行されます：
   - MySQLコンテナ起動
   - データベース`asukaelshop`作成
   - テーブル定義の自動適用（`database/schema/01-init-schema.sql`）
   - Webサーバー起動（http://localhost:8080）
   - MailHog起動（http://localhost:8025）

### 初期化テスト
```bash
cd docker
docker-compose exec db mysql -u root -proot -e "USE asukaelshop; SHOW TABLES;"
```

### XAMPP環境
1. XAMPPをインストール・起動
2. MySQLでデータベース`asukaelshop`を作成
3. `database/schema/01-init-schema.sql`を手動実行
4. プロジェクトファイルを`htdocs`に配置

## アクセス方法
- **Webアプリケーション**: http://localhost:8080
- **MailHog（メール確認）**: http://localhost:8025
- **MySQL**: localhost:3307（root/root）

## ブランチ戦略・運用方針
- 本プロジェクトはbranchStrategy.mdに基づき、`master`/`develop`/`feature`/`fix`ブランチで運用します。
- 詳細は `memory-bank/branchStrategy.md` を参照してください。

## ライセンス
MIT License

## 貢献
プルリクエストやIssueを歓迎します。

---

※ MCPサーバーや外部連携は現状利用していません。今後の開発・運用はbranchStrategy.mdに基づき進めます。 