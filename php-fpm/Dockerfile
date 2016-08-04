FROM debian:jessie 
RUN apt-get update && apt-get install -y wget
RUN echo deb http://packages.dotdeb.org jessie all >> /etc/apt/sources.list
RUN echo deb-src http://packages.dotdeb.org jessie all >> /etc/apt/sources.list
RUN wget https://www.dotdeb.org/dotdeb.gpg && apt-key add dotdeb.gpg
RUN apt-get update && apt-get install -y php7.0 php7.0-common php7.0-ldap php7.0-fpm php7.0-json php7.0-mcrypt
COPY www.conf /etc/php/7.0/fpm/pool.d/www.conf
COPY php-fpm.conf /etc/php/7.0/fpm/php-fpm.conf

COPY scriptsrc /usr/share/nginx/html

CMD /usr/sbin/php-fpm7.0 --nodaemonize --fpm-config /etc/php/7.0/fpm/php-fpm.conf

EXPOSE 9000
