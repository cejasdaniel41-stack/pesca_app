FROM php:8.2-apache

# Instalar mysqli
RUN docker-php-ext-install mysqli

# Copiar el código al directorio web
COPY . /var/www/html/

# Exponer el puerto 80 (Apache)
EXPOSE 80

# El CMD por defecto ya arranca Apache, no hace falta cambiarlo
# Si quieres puedes dejarlo explícito:
CMD ["apache2-foreground"]
