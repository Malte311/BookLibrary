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
docker pull phpdoc/phpdoc
docker run --rm -v $(pwd):/data phpdoc/phpdoc -d ./src -t ./docs
chmod 777 ./docs
rm -r ./docs/phpdoc-cache-*