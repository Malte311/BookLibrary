FROM kimbtechnologies/php_smtp_nginx:latest

COPY --chown=www-data:www-data ./src/ /src/

ENV PROD=prod