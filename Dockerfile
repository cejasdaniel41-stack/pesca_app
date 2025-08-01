# Imagen base de PHP con Apache
FROM php:8.2-apache

# Copiar archivos del proyecto
COPY . /var/www/html/

# Configurar Apache
EXPOSE 10000
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
