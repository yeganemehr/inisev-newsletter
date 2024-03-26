FROM ghcr.io/dnj/laravel-alpine:8.2-mysql-nginx

COPY --chown=www-data . /var/www/
RUN composer install && 
	rm -f .env && \
	composer clear-cache
	chown -R www-data:www-data /var/www/
