FROM php:8.1-apache

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql zip

# Apache設定
RUN a2enmod rewrite

# 作業ディレクトリを設定
WORKDIR /var/www

# ファイルのコピー
COPY ../public /var/www/html
COPY ../src /var/www/src

# 権限設定
RUN chown -R www-data:www-data /var/www

EXPOSE 80

CMD ["apache2-foreground"] 