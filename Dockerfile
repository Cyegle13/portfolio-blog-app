# PHP8.3 + Apacheベースイメージ
FROM php:8.3-apache

# 必要なパッケージのインストール
# Apacheのmod_rewrite有効化
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    curl \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && a2enmod rewrite

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリ作成
WORKDIR /var/www/html

# Laravelアプリをコピー
COPY ./ /var/www/html

# ApacheのDocumentRootをLaravelのpublicに設定
ENV APACHE_DOCUMENT_ROOT "/var/www/html/public"

# Laravel用ディレクトリの権限設定
# Composerで依存解決
# Apache設定をLaravel用に調整
# Laravel初期設定
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache \
    && composer install --no-interaction --prefer-dist --optimize-autoloader \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && composer dump-autoload \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# 必要ポート公開（Apacheのデフォルト80）
EXPOSE 80

# 起動コマンド（Apacheをフォアグラウンドで実行）
CMD ["apache2-foreground"]
