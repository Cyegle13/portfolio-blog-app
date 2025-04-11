# PHP8.3 + Apacheベースイメージ
FROM php:8.3-fpm-alpine

# 必要なパッケージのインストール
# Apacheのmod_rewrite有効化
RUN apk update && apk add --no-cache \
    git \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    libpq-dev

RUN docker-php-ext-install pdo zip pgsql pdo_pgsql

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ作成
WORKDIR /var/www/html

# Laravelアプリをコピー
COPY . .

# Laravel初期設定
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && composer dump-autoload \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 必要ポート公開
EXPOSE 80

# 起動コマンド
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
