# branchStrategy.md

## ブランチ戦略（プランモード提案）

### 1. 前提
- 少人数または個人開発を想定（大規模なチーム開発ではない）
- シンプルな商品・在庫管理Webシステム
- 今後も機能追加や改善（画像管理、バリデーション強化、UI/UX改善など）が予定されている
- ドキュメントや構成の明確化を重視

---

### 2. 推奨ブランチ戦略

#### ● メインブランチ
- `master`（または `main`）
  - 常にリリース可能な安定状態を保つ
  - 本番反映や配布はこのブランチから

#### ● 開発用ブランチ
- `develop`
  - 日常的な開発のベース
  - 複数の機能開発や修正を統合し、安定したら `master` へマージ

#### ● 機能/課題ごとのトピックブランチ
- `feature/<機能名>`
  - 例: `feature/image-upload`, `feature/validation`
  - 新機能や大きな改修ごとに作成し、完了後 `develop` へマージ
- `fix/<修正内容>`
  - 例: `fix/csv-encoding`, `fix/search-bug`
  - バグ修正や小規模な改善用

#### ● リリース/ホットフィックスブランチ（必要に応じて）
- `release/<バージョン>`
  - 本番リリース前の最終調整用（大規模開発でなければ省略可）
- `hotfix/<内容>`
  - 本番環境の緊急修正用（必要時のみ）

---

### 3. 運用ルール例
- 新機能や修正は必ずトピックブランチで作業し、`develop`にプルリクエスト（またはマージ）
- `develop`が安定したら`master`へマージし、タグ付け・リリース
- ドキュメントや設計変更も、`feature/docs-update`などで管理
- 不要なブランチはマージ後に削除し、リポジトリを整理

---

### 4. シンプル運用例（個人・小規模向け）
- `master` のみで管理し、機能ごとに一時的なブランチを作成→完了後すぐマージ＆削除
- 例:
  ```
  git checkout -b feature/image-upload
  ...作業...
  git commit -am "Add image upload"
  git checkout master
  git merge feature/image-upload
  git branch -d feature/image-upload
  ```

---

### まとめ
- 推奨：`master`＋`develop`＋トピックブランチ（feature/fix）運用
- シンプル運用も可（`master`のみ＋一時ブランチ）
- ドキュメントや設計変更もブランチ管理対象に含めると良い 