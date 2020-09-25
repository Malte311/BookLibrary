# :books: BookLibrary

![Build Status](https://travis-ci.com/Malte311/BookLibrary.svg?branch=master)
[![GitHub license](https://img.shields.io/github/license/Malte311/BookLibrary)](https://github.com/Malte311/BookLibrary/blob/master/LICENSE)
[![Documentation](https://img.shields.io/badge/-documentation-informational)](https://malte311.github.io/BookLibrary/)

> _BookLibrary_ is a library for book notes.
> In fact, _BookNoteLibrary_ would be a more appropriate name since the idea is to manage book notes -- not whole books.

## :whale: Installation (in three simple steps via Docker)

1. Download the `docker-compose.yml` file _or_ clone the whole repository:

```bash

git clone git@github.com:Malte311/BookLibrary.git

```

2. Adjust the `docker-compose.yml` file. Specify the correct urls and adjust the port.

```yaml

version: "2"

services:
  web:
    image: quay.io/malte311/book-library:latest
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
After the installation, run `php userAdministration.php add` on the command line in order to create an initial user. Afterwards, you can log into the application using the credentials you just created. This script allows you to _delete_, _edit_ or _list_ all available users as well. Simply replace the parameter `add` with `delete`, `edit` or `list`, respectively.

While logged in, you can view, filter and sort all book note files which are present in the `data/` directory. In order to get rid of the example files from this repository, simple delete them in the `data/` folder. For adding new book notes, place their corresponding markdown files in the `data/books/` folder (and optionally the book cover in the `data/covers/` folder). A detailed guide on how to manage the book note files can be found [here](https://github.com/Malte311/BookLibrary/blob/master/src/data/README.md).

The content of each book note file can be viewed by clicking on the corresponding card in the overview. When viewing the statistics, keep in mind that each book can be read multiple times, i.e., the numbers do not represent unique books read.

## :page_facing_up: License

This project is licensed under the [MIT License](https://github.com/Malte311/BookLibrary/blob/master/LICENSE).
