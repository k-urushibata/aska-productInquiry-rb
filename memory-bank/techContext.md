# techContext.md

## 使用技術
- PHP 7.x 以降
- MySQL 5.7 以降
- HTML/CSS
- メール送信: PHPMailer＋SMTP（MailHog）

## 開発環境
- 本番環境: XAMPP
- 開発環境: Docker（LAMP構成＋MailHog）
  - web: php:8.1-apache（/var/www/html, /var/www/src）
  - db: mysql:8.0（ポート3307）
  - mailhog: mailhog/mailhog（SMTP:1025, Web:8025）
- DB: asukaelshop
- メールテスト: MailHog（Docker環境, http://localhost:8025）
- composer, unzip, php-zip, libzip-dev導入（webコンテナ）

## Docker運用・構成のポイント
- docker-composeでweb/db/mailhogを一括起動・停止
- webコンテナにはcomposer/unzip/php-zip/libzip-devをaptで導入し、PHPMailerをcomposerで管理
- メール送信はMailHogのSMTP（mailhog:1025）を利用し、MailHogのWeb UIでテスト確認
- 本番環境ではMailHogの代わりに実際のSMTPサーバーを設定予定
- DBスキーマ・初期データはdatabase/schema/以下で管理し、dbサービス起動時に自動適用

## 技術的制約
- 商品画像の管理は現状未対応
- ユーザー認証なし
- メール送信にはSMTP設定が必要
- mail()関数は使わず、PHPMailer＋SMTPで送信

## 依存関係
- PHP PDO拡張
- PHPMailer（composerで管理）
- unzip, php-zip, libzip-dev（webコンテナ）

## ツールの使用パターン
- DBスキーマはSQLファイルで管理
- データ一括登録はCSVファイル
- Web UIはPHPで実装
- 設定情報はconfigファイルで管理
- Docker Composeで開発環境を統一 