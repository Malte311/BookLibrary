# :books: BookLibrary

![Build Status](https://travis-ci.com/Malte311/BookLibrary.svg?branch=master)
[![GitHub license](https://img.shields.io/github/license/Malte311/BookLibrary)](https://github.com/Malte311/BookLibrary/blob/master/LICENSE)

> _BookLibrary_ is a library for book notes.
> In fact, _BookNoteLibrary_ would be a more appropriate name since the idea is to manage book notes -- not whole books.

:warning: This application is still work in progress (the Docker setup is not finished yet)!

## :whale: Installation (in three simple steps via Docker)

1. Download this repository:

```bash

git clone git@github.com:Malte311/BookLibrary.git

```

2. Adjust the `docker-compose.yml` file. Specify the correct urls and adjust the port.

```yaml

version: "2"

services:
  web:
    image: malte311/book-library:latest
    container_name: book-library
    ports:
      - "127.0.0.1:8080:80"
    volumes:
      - ./data/:/php-code/data/
    restart: always
    environment:
      - BASEURL=https://example.com
      - SERVERURL=https://example.com/book-library
      - IMPRESSUMURL=https://example.com/impressum
      - DATENSCHUTZURL=https://example.com/datenschutz

```

3. Get the newest Docker image and start a Docker container (inside of the project folder):

```bash

docker-compose pull
docker-compose up -d

```

## :book: Usage
> Todo.

## :page_facing_up: License

This project is licensed under the [MIT License](https://github.com/Malte311/BookLibrary/blob/master/LICENSE).
