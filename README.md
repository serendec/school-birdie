# School Birdie - LMS システム

教育機関向けの学習管理システム（LMS）です。

## システム要件

- PHP 8.1以上
- MySQL 5.7以上
- Node.js 16以上
- Composer
- NPM

## ローカル環境での起動方法

### 1. リポジトリのクローン

```bash
git clone <repository-url>
cd school-birdie
```

### 2. 依存関係のインストール

```bash
# PHP依存関係のインストール
composer install

# Node.js依存関係のインストール
npm install
```

### 3. 環境設定

`.env`ファイルを作成し、以下の設定を行います：

```bash
# アプリケーションキーの生成
php artisan key:generate

# .envファイルの設定例
APP_NAME="School Birdie"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost:8000

# データベース設定
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_birdie
DB_USERNAME=root
DB_PASSWORD=

# メール設定（Mailpit使用）
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

# reCAPTCHA設定
RECAPTCHA_SITE_KEY=your_site_key
RECAPTCHA_SECRET_KEY=your_secret_key
```

### 4. データベースのセットアップ

```bash
# データベースの作成（MySQLで実行）
CREATE DATABASE school_birdie;

# マイグレーションの実行
php artisan migrate

# シーダーの実行（テストデータの投入）
php artisan db:seed
```

### 5. ストレージリンクの作成

```bash
# ストレージシンボリックリンクの作成
php artisan storage:link

# 必要なディレクトリの作成
mkdir -p public/storage/img
mkdir -p public/storage/icons
chmod -R 755 storage/app/public/
chmod -R 755 public/storage/
```

### 6. フロントエンドアセットのビルド

```bash
# 開発用ビルド
npm run dev

# または本番用ビルド
npm run build
```

### 7. アプリケーションの起動

#### 方法1: 同時起動（推奨）

```bash
# 依存関係のインストール（concurrentlyパッケージ）
npm install

# Laravel開発サーバーとMailpitを同時起動
npm run serve
# または
npm start
```

#### 方法2: 個別起動

```bash
# Mailpitのインストール（Homebrew使用）
brew install mailpit

# Mailpitの起動（別ターミナル）
mailpit --smtp 127.0.0.1:1025 --listen 127.0.0.1:8025 &

# Laravel開発サーバーの起動（別ターミナル）
php artisan serve --host=0.0.0.0 --port=8000
```

**アクセス先:**
- アプリケーション: `http://localhost:8000`
- Mailpit WebUI: `http://localhost:8025` または `http://127.0.0.1:8025`

### 8. システムの停止

#### 方法1: 同時起動の場合
```bash
# Ctrl+C で両方のプロセスを同時に停止
```

#### 方法2: 個別起動の場合
```bash
# Laravel開発サーバーを停止
# ターミナルで Ctrl+C

# Mailpitを停止
# ターミナルで Ctrl+C
# またはバックグラウンドプロセスの場合
pkill mailpit
```

#### 強制停止（プロセスが残っている場合）
```bash
# Laravel開発サーバーを強制停止
pkill -f "php artisan serve"
pkill -f "php -S 0.0.0.0:8000"

# Mailpitを強制停止
pkill mailpit

# ポート使用状況の確認
lsof -i :8000  # Laravel開発サーバー
lsof -i :8025  # Mailpit
```

## 主要機能

- ユーザー管理（スーパー管理者、管理者、講師、生徒）
- コース管理
- 動画配信
- フォーラム機能
- 動画添削機能
- レッスン記録管理
- お気に入り機能

## 開発時の注意事項

- 画像アップロード機能を使用する場合は、適切な権限設定が必要です
- メール送信機能のテストにはMailpitを使用してください
- reCAPTCHAの設定は本番環境用のキーを使用してください

## トラブルシューティング

### よくある問題

1. **ストレージリンクエラー**
   ```bash
   php artisan storage:link
   ```

2. **権限エラー**
   ```bash
   chmod -R 755 storage/
   chmod -R 755 public/storage/
   ```

3. **メール送信エラー**
   - Mailpitが起動しているか確認
   - `.env`のメール設定を確認

4. **reCAPTCHAエラー**
   - `.env`のreCAPTCHAキーを確認
   - 正しいサイトキーとシークレットキーを設定

## ライセンス

このプロジェクトのライセンスについては、プロジェクト管理者にお問い合わせください。
