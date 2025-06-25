---
name: 入力バリデーション強化
about: データ整合性とセキュリティのための包括的バリデーション実装
title: '[ENHANCEMENT] 入力バリデーション強化'
labels: ['enhancement', 'validation', 'security', 'bug-fix']
assignees: ''
projects: ''
milestone: ''
---

## 📋 概要
現在のシステムでは基本的な入力チェックのみが実装されており、データの整合性やセキュリティ面で改善が必要です。CSVアップロード、検索機能、問い合わせ機能において、包括的なバリデーションを実装します。

## 🔍 現状
- CSVアップロード時の基本的なファイル形式チェックのみ
- 検索機能での入力値チェックが不十分
- 問い合わせフォームのバリデーションが基本的
- SQLインジェクション対策は実装済み（プリペアドステートメント使用）

## 🎯 要件

### CSVアップロード機能
- [ ] ファイルサイズ制限（例：10MB以下）
- [ ] ファイル形式チェック（.csvのみ許可）
- [ ] 必須カラムの存在確認
- [ ] データ型チェック（数値、文字列、日付等）
- [ ] 文字エンコーディングチェック（UTF-8対応）
- [ ] 重複データの検出・処理
- [ ] 不正な文字（HTMLタグ、スクリプト等）の除去

### 検索機能
- [ ] 検索キーワードの長さ制限
- [ ] 特殊文字のエスケープ処理
- [ ] 空文字列での検索実行防止
- [ ] 検索結果件数の制限（パフォーマンス考慮）

### 問い合わせ機能
- [ ] メールアドレスの形式チェック
- [ ] 名前の長さ制限（1-50文字）
- [ ] メッセージの長さ制限（1-1000文字）
- [ ] 必須項目の入力チェック
- [ ] スパム対策（同一IPからの連続送信制限）

## 🛠️ 技術仕様

### バリデーションクラスの実装
```php
class Validator {
    public static function validateEmail($email) { /* ... */ }
    public static function validateCsvFile($file) { /* ... */ }
    public static function validateSearchKeyword($keyword) { /* ... */ }
    public static function sanitizeInput($input) { /* ... */ }
}
```

### エラーメッセージの統一
- 日本語での分かりやすいエラーメッセージ
- エラーコードの統一
- ユーザーへの修正案提示

### フロントエンドバリデーション
- JavaScriptによるリアルタイムバリデーション
- HTML5のバリデーション属性活用
- ユーザビリティを考慮したエラー表示

## 📁 実装方針

### 1. バックエンドバリデーション
- 各Controllerにバリデーション処理を追加
- 共通のバリデーションクラスを作成
- エラーハンドリングの統一

### 2. フロントエンドバリデーション
- JavaScriptファイルの作成
- フォーム送信前の事前チェック
- ユーザーフレンドリーなエラー表示

### 3. セキュリティ強化
- XSS対策の強化
- CSRF対策の実装
- 入力値のサニタイゼーション

## 📝 実装項目

### バックエンド
- [ ] `src/utils/Validator.php`の作成
- [ ] `src/controllers/UploadController.php`のバリデーション強化
- [ ] `src/controllers/InventoryController.php`の検索バリデーション
- [ ] `src/controllers/InquiryController.php`のフォームバリデーション
- [ ] 共通バリデーション処理の実装

### フロントエンド
- [ ] `public/js/validation.js`の作成
- [ ] CSVアップロードフォームのバリデーション
- [ ] 検索フォームのバリデーション
- [ ] 問い合わせフォームのバリデーション
- [ ] リアルタイムエラー表示

### セキュリティ
- [ ] XSS対策の実装
- [ ] CSRFトークンの実装
- [ ] 入力値サニタイゼーション
- [ ] ファイルアップロードセキュリティ

## 🧪 テスト項目
- [ ] CSVファイルの各種バリデーションテスト
- [ ] 検索機能の入力値チェックテスト
- [ ] 問い合わせフォームのバリデーションテスト
- [ ] エラーメッセージの表示確認
- [ ] セキュリティテスト（XSS、CSRF等）

## 📚 参考資料
- [PHP Input Validation](https://www.php.net/manual/en/security.database.sql-injection.php)
- [OWASP Input Validation](https://owasp.org/www-project-proactive-controls/v3/en/c5-validate-inputs)
- [HTML5 Form Validation](https://developer.mozilla.org/en-US/docs/Learn/Forms/Form_validation)

## 🏷️ ラベル
- `enhancement` - 機能拡張
- `validation` - バリデーション
- `security` - セキュリティ
- `bug-fix` - バグ修正

## ⚡ 優先度
**高** - データ整合性とセキュリティのため 