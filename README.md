# minimal-php-v3

## Overview

シンプルなTODOアプリケーション。Docker Compose環境でPHP + MySQL + Nginxを使用した基本的なCRUD操作を実装しています。CSRFトークン保護を含むセキュアな実装を学習用に提供します。

## Tech Stack

- **Backend**: PHP 8.x
- **Database**: MySQL 8.4
- **Web Server**: Nginx 1.26 Alpine
- **Environment**: Docker & Docker Compose
- **Dependencies**:
  - vlucas/phpdotenv (環境変数管理)

## Setup

1. リポジトリをクローン:
```bash
git clone <repository-url>
cd minimal-php-v3
```

2. 環境変数ファイルを作成:
```bash
cp .env.sample .env
```

3. `.env` ファイルを編集してデータベース設定を入力:
```
DB_HOST=db
DB_PORT=3306
DB_ROOT_PASS=your_root_password
DB_NAME=your_database_name
DB_USER=your_username
DB_PASS=your_password
DB_CHARSET=utf8mb4
```

4. Dockerコンテナを起動:
```bash
docker compose up -d
```

5. データベースの初期化 (必要に応じて):
```bash
docker exec -i mysql mysql -u root -p<your_root_password> <your_database_name> < src/app/main.sql
```

## Usage

- アプリケーションにアクセス: http://localhost:8080
- **TODO追加**: テキストフィールドに入力してEnter
- **完了切り替え**: チェックボックスをクリック
- **削除**: 各TODOの右側の「x」をクリック

### コンテナ管理

```bash
# コンテナの起動
docker compose up -d

# コンテナの停止
docker compose down

# ログの確認
docker compose logs -f

# PHPコンテナに入る
docker exec -it php bash
```

## Directory Structure

```
.
├── nginx/              # Nginx設定ファイル
│   └── default.conf
├── php/                # PHPコンテナの設定
│   ├── Dockerfile
│   └── php.ini
├── src/                # アプリケーションソースコード
│   ├── app/
│   │   ├── config.php      # 設定とPDO接続
│   │   ├── functions.php   # CRUD関数
│   │   └── main.sql        # データベーススキーマ
│   ├── public/
│   │   ├── index.php       # エントリーポイント
│   │   ├── css/
│   │   └── js/
│   └── composer.json
├── .env                # 環境変数（gitignore対象）
├── .env.sample         # 環境変数のサンプル
└── docker-compose.yml  # Docker Compose設定
```

## License

This repository is for personal/private use only.
