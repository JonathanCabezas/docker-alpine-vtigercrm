FROM samirkherraz/alpine-s6

ENV VTIGER_VERSION=7.1.0 \
    DATABASE_HOST=localhost \
    DATABASE_PORT=3306 \
    VTIGER_DB_NAME=vtiger \
    VTIGER_DB_USERNAME=vtiger \
    VTIGER_DB_PASSWORD=password \
    ADMIN_USERNAME=admin \
    ADMIN_PASSWORD=password \
    ADMIN_EMAIL=admin@exemple.org \
    TRUSTED_HOST=localhost

RUN set -x \
    && apk update \
    && apk add --no-cache php7 php7-pdo php7-imagick php7-intl php7-openssl php7-pear php7-pdo_mysql php7-gettext php7-mailparse php7-json php7-iconv php7-curl php7-fileinfo php7-zip php7-fpm php7-mysqli php7-gd php7-mbstring php7-imap php7-session php7-ctype php7-xml php7-simplexml php7-xmlwriter php7-xmlreader php7-ldap mariadb-client \
    && apk add --no-cache nginx \
    && rm /etc/nginx/conf.d/default.conf \
    && mkdir /run/nginx \
    && rm -R /var/www/* || true \
    && chown nginx:nginx /run/nginx

ADD conf/ /

RUN set -x \
    && chmod +x /etc/cont-init.d/* \
    && chmod +x /etc/s6/services/*/* \
    && chmod +x /etc/periodic/*/*
