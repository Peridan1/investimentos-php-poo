FROM php:8.2-apache

# Instala as extensões necessárias para o banco de dados
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilita o mod_rewrite do Apache (útil para rotas amigáveis)
RUN a2enmod rewrite

# Altera o DocumentRoot do Apache para a pasta public/
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Permite que o .htaccess funcione (AllowOverride All)
RUN sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Define o diretório de trabalho
WORKDIR /var/www/html