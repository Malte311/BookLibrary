FROM kimbtechnologies/php_nginx:latest

COPY --chown=www-data:www-data ./src/ /src/

ENV PROD=prod