FROM php:7-cli

EXPOSE 8080

VOLUME /usr/shared/app

CMD php -S 0.0.0.0:8080 -t /usr/local/app

ENV DATABASE_FILE '/usr/shared/app/notifierDB.db'

COPY notifierDB.db /usr/shared/app/
COPY vendor/ /usr/local/app/vendor/
COPY index/ /usr/local/app/index/
COPY index.php /usr/local/app/
COPY src/ /usr/local/app/src/
