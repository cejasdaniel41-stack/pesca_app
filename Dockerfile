# Imagen oficial de PHP con Apache
FROM php:8.2-apache

# Copiamos todos los archivos al directorio de Apache
COPY . /var/www/html/

# Exponemos el puerto 10000 (Render lo usa por defecto)
EXPOSE 10000

# Comando para iniciar el servidor PHP integrado
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
