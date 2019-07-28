FROM dakalab/nginx-php as builder

ENV MARIADB_NAME=mariadb
ENV MARIADB_PASSWORD=hello123

RUN apt-get update && apt-get install -y locales-all
