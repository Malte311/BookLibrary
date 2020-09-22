FROM kimbtechnologies/php_nginx:latest

RUN echo $' \n\
	# url rewriting error pages \n\
	error_page 404 /index.php?uri=err404; \n\
	error_page 403 /index.php?uri=err403; \n\
	# protect private files and directories \n\
	location = /userAdministration.php { \n\
        deny all; \n\
        return 403; \n\
    } \n\
	location ~ ^/(data|php){ \n\
		deny all; \n\
		return 403; \n\
	} \n\
	' > /etc/nginx/more-server-conf.conf

COPY --chown=www-data:www-data ./src/ /php-code/
COPY /startup-before.sh /

ENV PROD=prod