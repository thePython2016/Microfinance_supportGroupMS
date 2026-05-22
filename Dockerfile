FROM php:8.2-apache

# PostgreSQL PDO driver (required on Render; default PHP image only has sqlite/mysql).
RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY . /var/www/html/

# Strip UTF-8 BOM from PHP files (invisible bytes before <?php break sessions/headers).
RUN find /var/www/html -name '*.php' -type f -print0 \
    | xargs -0 -I{} php -r '$p=$argv[1];$c=@file_get_contents($p);if($c!==false&&strncmp($c,"\xEF\xBB\xBF",3)===0){file_put_contents($p,substr($c,3));}'

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
