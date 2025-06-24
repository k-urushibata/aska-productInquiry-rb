# activeContext.md

## 現在の作業の焦点
- Go実装MCPサーバー（github-mcp-server）への切り替え
- Node.js版MCPサーバー関連ファイル・依存の削除
- Go用config.yamlの新規作成
- READMEのセットアップ手順をGo版に修正

## 最近の変更内容
- Node.js版MCPサーバー関連ファイルの削除：
  - mcp/mcp-config.json
  - mcp/mcp-setup.md
  - mcp/env.example
  - package.jsonから@modelcontextprotocol/server-github, dotenv, dotenv-cli, zod-to-json-schema, mcp:githubスクリプトを削除
- Go実装MCPサーバー用config.yamlをmcp/に追加
- README.mdをGo実装MCPサーバーの手順に全面修正

## 次のステップ
- Go実装MCPサーバーのビルド・起動
- config.yamlの内容調整
- GitHubリポジトリ作成APIの動作確認

## 現在の判断・考慮事項
- MCPサーバーのHTTP API利用にはGo実装が必須
- Node.js版はstdioモードのみでAPIリクエスト不可
- 設定ファイルはYAML形式で管理
- 依存パッケージは最小限に

## 重要なパターン・好み
- プロジェクト構造の明確化
- 不要なファイルは積極的に削除
- ドキュメントは常に最新に保つ

## 学び・洞察
- MCPサーバーの実装方式によるAPI利用可否の違い
- 公式ドキュメントの確認の重要性
- プロジェクトの技術選定は要件・運用に応じて柔軟に見直す 