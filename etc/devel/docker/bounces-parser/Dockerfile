FROM php:7-cli-alpine3.7

RUN apk add --no-cache supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mkdir -p /var/www/bounces/current
RUN mkdir -p /etc/supervisor/conf.d
ADD supervisor/conf.d/* /etc/supervisor/conf.d/
RUN rm /etc/supervisord.conf
ADD supervisor/conf/supervisord.conf /etc
ADD scripts/* /usr/local/bin
RUN chmod 777 /usr/local/bin/start.sh

WORKDIR /var/www/bounces/current

CMD /usr/local/bin/start.sh
