# みんなの部活応援隊 (Laravel 10)

島根県内の部活動と企業支援をマッチングするシングルページアプリケーションです。既存のデザインと振る舞いを保ちつつ Laravel 10 の仕組みでサーバーサイド化しました。

## 主な機能
- ホーム・部活動一覧・部活動登録・企業登録・企業ログインの各セクションを SPA 風に表示切り替え
- クラブ登録／企業登録フォームのバリデーションと JSON ファイルへの永続化
- デモ用の簡易ログイン (メール `test@example.com`, パスワード `password123`)
- ログイン済みの場合のみクラブに対してマッチング申請を送信
- すべての API は Laravel の CSRF 保護付きルートで実装

## 動作要件
- PHP 8.1 以上 (拡張: `mbstring`, `openssl`, `pdo_sqlite` 等 Laravel が要求する標準拡張)
- Composer 2 以上
- Node.js 18 以上 (スタイルは純粋な CSS のため必須ではありません)

## 環境構築手順 (Docker 不使用)
1. **ソース取得**
   ```bash
   git clone <this-repo-url> shimane_club
   cd shimane_club
   ```
2. **依存ライブラリのインストール**
   ```bash
   composer install
   ```
3. **環境変数ファイルの作成**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   - デモログイン情報を変更したい場合は `.env` 内の `DEMO_LOGIN_*` を編集してください。
4. **データベース/ストレージの準備**
   - SQLite を使用する場合は `database/database.sqlite` を作成します。
     ```bash
     touch database/database.sqlite
     ```
   - JSON 永続化用ディレクトリ (クラブ・企業データ) は `storage/app/data` 配下にあります。初期データはコミット済みですが、権限が必要な場合は `storage` 以下を web サーバーから書き込み可能にしてください。
5. **開発サーバーの起動**
   ```bash
   php artisan serve
   ```
   もしくは任意の Web サーバーを `public/` に向けてください。

## 使い方
- トップページの各ボタン／ナビゲーションは `SPA` のように各セクションへスクロールせず切り替わります。
- クラブ登録フォーム送信後は自動的に一覧へ遷移し、新しいクラブカードが追加されます。
- 企業登録フォームは内容を `storage/app/data/companies.json` に保存し、完了メッセージを表示します。
- 企業ログインフォームは `.env` のデモ資格情報に一致した場合のみ成功し、ログイン中はナビゲーションが切り替わってマッチング申請ボタンがアクティブになります。

## テスト
ユニット／機能テストはまだ用意していません。必要に応じて `tests/` 以下に追加し、`php artisan test` を実行してください。

## ファイル構成ハイライト
- `resources/views/app.blade.php` … 元のデザインを移植した Blade テンプレート
- `app/Http/Controllers/*` … 認証／クラブ／企業 API
- `app/Services/*` … JSON ストレージを扱う簡易リポジトリ
- `storage/app/data/*.json` … 初期クラブデータと企業データの保存場所

