#!/bin/bash

# Docker build
IMAGE_NAME='book-library'

echo "$DOCKER_TOKEN" | docker login -u "$DOCKER_USER" --password-stdin quay.io
docker build -t $IMAGE_NAME .
docker images

cat VERSION | while read TAG; do
	if [[ $TAG =~ ^#.* ]] ; then 
		echo "Skipping $TAG";
	else 
		echo "Tagging Image as $TAG and pushing";
		docker tag $IMAGE_NAME "quay.io/malte311/$IMAGE_NAME:$TAG"
      	docker push "quay.io/malte311/$IMAGE_NAME:$TAG"
	fi
done

# PHPDoc
curl -L https://github.com/phpDocumentor/phpDocumentor/releases/download/v3.0.0-rc/phpDocumentor.phar --output phpDocumentator.phar
php phpDocumentator.phar --ignore src/php/Reader.php --ignore src/php/JsonReader.php -d ./src -t ./docs --template="clean"