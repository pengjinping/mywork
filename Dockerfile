#FROM jguyomard/laravel-php:7.3
#FROM php:7.3-fpm-alpine
FROM registry.cn-huhehaote.aliyuncs.com/pengjinping/php7.2

#WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www/html
#COPY ./deploy/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/
RUN chmod a+w -R /var/www/html/storage /var/www/html/bootstrap/cache \
    && rm /usr/local/etc/php-fpm.d/zz-docker.conf

# Copy existing application directory permissions
#COPY --chown=www:www . /var/www

# Change current user to www
#USER www

# Expose port 9000 and start php-fpm server
#Expose 9000
#CMD ["php-fpm"]
#CMD ["php-fpm", "--nodaemonize"]

ENTRYPOINT ["/var/www/html/init.sh"]
