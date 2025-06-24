FROM php:8.1-apache

# 必要なパッケージ・拡張をインストール
RUN apt-get update && \
    apt-get install -y unzip git libzip-dev && \
    docker-php-ext-install zip pdo pdo_mysql

# Composerインストール
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Apacheのmod_rewrite有効化
RUN a2enmod rewrite

# ドキュメントルート設定
ENV APACHE_DOCUMENT_ROOT /var/www/html

# PHPMailerをcomposerでインストール
WORKDIR /var/www/html
COPY docker/composer.json composer.json
RUN composer install

# src, publicディレクトリをイメージに含める（初回ビルド用）
COPY ../src /var/www/src
COPY ../public /var/www/html

# 権限設定
RUN chown -R www-data:www-data /var/www

EXPOSE 80

CMD ["apache2-foreground"] 