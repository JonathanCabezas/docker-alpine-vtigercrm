# Vtiger 7.1.10

# Auto configuration parameters :

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

# Compose file exemple

```

version: '3.1'

services:

  vtigercrm:
    image: vtigercrm
    environment:
      - DATABASE_HOST=mariadb
      - DATABASE_PORT=3306
      - VTIGER_DB_NAME=vtigercrm
      - VTIGER_DB_USERNAME=vtigercrm
      - VTIGER_DB_PASSWORD=password
      - ADMIN_USERNAME=minad
      - ADMIN_PASSWORD=test1234
      - ADMIN_EMAIL=minad@test.com
      - TRUSTED_HOST=172.17.0.1:8080
    ports:
      - 8080:80
    networks:
      default:
    volumes:
      - /tmp/vtigercrm:/var/www/vtigercrm/
    deploy:
      resources:
        limits:
          memory: 256M
      restart_policy:
        condition: on-failure
      mode: global

  mariadb:
    image: samirkherraz/mariadb
    environment:
      - ROOT_PASSWORD=password
      - DB_0_NAME=vtigercrm
      - DB_0_PASS=password
    ports:
      - 3306:3306
      - 8081:80
    volumes:
      - mariadb-data:/var/lib/mysql/
      - mariadb-config:/etc/mysql/
    networks:
      default:
    deploy:
      resources:
        limits:
          memory: 256M
      restart_policy:
        condition: on-failure
      mode: global

volumes:
    mariadb-data:
    mariadb-config:

```
