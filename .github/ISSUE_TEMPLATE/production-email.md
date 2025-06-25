---
name: 本番メール送信対応
about: 本番環境でのメール送信機能（Gmail等SMTP対応）の実装
title: '[ENHANCEMENT] 本番メール送信対応'
labels: ['enhancement', 'email', 'production', 'security']
assignees: ''
projects: ''
milestone: ''
---

## 📋 概要
現在の問い合わせ機能はMailHog（開発環境用）でのみ動作しています。本番環境ではGmailやその他のメールサーバーに問い合わせメールを送信できるよう、PHPMailerのSMTP設定を拡張する必要があります。

## 🔍 現状
- 問い合わせ機能はPHPMailer＋MailHog SMTPで実装済み
- 開発環境ではMailHog（http://localhost:8025）でメール送信テストが可能
- 本番環境でのメール送信は未対応

## 🎯 要件
- Gmail、Outlook、その他のSMTPサーバーへの問い合わせメール送信
- 環境に応じたSMTP設定の切り替え（開発/本番）
- セキュアな認証情報の管理

## 🛠️ 技術仕様

### Gmail SMTP設定例
```
Host: smtp.gmail.com
Port: 587
Security: TLS
Authentication: Required
Username: your-email@gmail.com
Password: アプリパスワード（2段階認証必須）
```

### その他のメールサーバー例
- Outlook: smtp-mail.outlook.com:587
- Yahoo: smtp.mail.yahoo.com:587
- 独自SMTP: サーバー設定に応じて

## 📁 実装方針

### 1. 設定ファイルの拡張
- `src/config/mail.php` に本番SMTP設定を追加
- 環境変数による設定切り替え
- セキュアな認証情報管理

### 2. InquiryControllerの修正
- MailConfigから本番SMTP設定を取得
- SMTP認証情報をPHPMailerに設定
- エラーハンドリングの強化

### 3. 環境別設定
- 開発環境: MailHog SMTP
- 本番環境: 実際のSMTPサーバー

## 📝 実装項目

### 設定ファイル
- [ ] `src/config/mail.php`の拡張
- [ ] 環境変数設定の追加
- [ ] 本番SMTP設定の追加

### コントローラー修正
- [ ] `src/controllers/InquiryController.php`の修正
- [ ] SMTP認証処理の実装
- [ ] エラーハンドリングの強化

### 環境設定
- [ ] `.env`ファイルの作成
- [ ] 環境変数の設定
- [ ] セキュリティ設定の確認

## 🔒 セキュリティ考慮事項
- メールパスワードは環境変数で管理
- アプリパスワードの使用（Gmail等）
- SMTP通信の暗号化（TLS/SSL）

## 🧪 テスト項目
- [ ] Gmail SMTPでのメール送信テスト
- [ ] その他のメールサーバーでの送信テスト
- [ ] 環境切り替えの動作確認
- [ ] エラーハンドリングの確認

## 📚 参考資料
- [PHPMailer Documentation](https://github.com/PHPMailer/PHPMailer)
- [Gmail SMTP Settings](https://support.google.com/mail/answer/7126229)
- [Google App Passwords](https://support.google.com/accounts/answer/185833)

## 🏷️ ラベル
- `enhancement` - 機能拡張
- `email` - メール機能
- `production` - 本番環境
- `security` - セキュリティ

## ⚡ 優先度
**中** - 本番環境での運用に必要 