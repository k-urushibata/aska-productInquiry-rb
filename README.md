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
- **AI連携**: Go実装MCPサーバー（github-mcp-server）

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
├── mcp/                 # MCP関連ファイル
│   └── config.yaml      # Go版MCPサーバー用設定ファイル
├── package.json         # Node.js依存関係（PHPアプリ用）
└── README.md            # プロジェクト説明
```

## セットアップ

### 1. Goのインストール
[Go公式ダウンロードページ](https://go.dev/dl/)

### 2. Go実装MCPサーバーの導入
```bash
git clone https://github.com/github/github-mcp-server.git
cd github-mcp-server
go build -o github-mcp-server .
```

### 3. 設定ファイルの作成
`mcp/config.yaml` を作成し、以下のように記述します：
```yaml
github:
  token: "YOUR_GITHUB_PERSONAL_ACCESS_TOKEN"
  username: "YOUR_GITHUB_USERNAME"
server:
  address: "0.0.0.0:3000"
```

### 4. サーバーの起動
```bash
./github-mcp-server serve --config ../aska-productInquiry-rb/mcp/config.yaml
```

### 5. 動作確認（リポジトリ作成例）
```bash
curl -X POST "http://localhost:3000/github/repos" \
  -H "Content-Type: application/json" \
  -d '{"name":"aska-productInquiry-rb","description":"商品在庫管理・検索システム","private":false}'
```

## トラブルシューティング
- GitHubトークンには`repo`権限が必要です。
- サーバー起動時のログやエラーを確認し、必要に応じて設定を調整してください。
- ポート3000が他のプロセスで使われていないか確認してください。

## ライセンス
MIT License

## 貢献
プルリクエストやIssueを歓迎します。 