# 商品在庫管理・検索システム

## 概要
商品情報と在庫数を一元管理し、検索・更新できるWebシステムです。

## 機能
- 商品マスタ管理（商品名、商品コード、価格、メーカ名、画像パス）
- 在庫管理（商品ID、在庫数）
- CSV一括登録・更新
- 商品名・メーカ名での部分一致検索
- 商品情報と在庫数の一覧表示

## 技術スタック
- **バックエンド**: PHP 8.0+
- **データベース**: MySQL 8.0+
- **フロントエンド**: HTML, CSS, JavaScript
- **開発環境**: Docker
- **本番環境**: XAMPP

## プロジェクト構造
```
aska-productInquiry-rb/
├── memory-bank/          # プロジェクトドキュメント
├── src/                  # PHPソースコード（MVC）
│   ├── config/          # データベース設定
│   ├── controllers/     # コントローラー
│   ├── models/          # モデル
│   └── views/           # ビュー
├── public/              # Web公開ディレクトリ
├── database/            # データベース関連
│   ├── schema/          # スキーマ定義
│   └── data/            # サンプルデータ
├── docker/              # Docker設定
└── README.md            # プロジェクト説明
```

## セットアップ

1. 必要な環境（PHP, MySQL, Docker, XAMPPなど）をインストール
2. `docker-compose.yml` で開発環境を起動（またはXAMPPで手動構築）
3. `database/schema/create_table.sql` でDBスキーマを作成
4. `database/data/inventory.csv` などでサンプルデータを投入
5. `public/index.php` からWebアプリにアクセス

## ブランチ戦略・運用方針
- 本プロジェクトはbranchStrategy.mdに基づき、`master`/`develop`/`feature`/`fix`ブランチで運用します。
- 詳細は `memory-bank/branchStrategy.md` を参照してください。

## ライセンス
MIT License

## 貢献
プルリクエストやIssueを歓迎します。

---

※ MCPサーバーや外部連携は現状利用していません。今後の開発・運用はbranchStrategy.mdに基づき進めます。 