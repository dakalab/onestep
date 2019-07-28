all: help

# it's important to declare we are using bash, otherwise some make commands may fail
SHELL := /bin/bash

NETWORK=backend
MARIADB_IMG=mariadb:10.4
MARIADB_NAME=mariadb
MARIADB_PASSWORD=hello123

help:
	###################################################################################
	#
	# conndb            - connect to MariaDB using root
	# logs              - tail the container logs
	# mariadb           - boot up mariadb container
	# mariadb-down      - remove mariadb container
	# network           - create docker bridge network
	# onestep           - boot up onestep container
	# onestep-down      - remove onestep container
	# pingdb            - check database health
	# prune             - run docker system prune
	# prune-data        - [danger] run docker system prune and also remove container volume
	# ps                - list all containers
	# restart           - restart container
	# sh                - enter the container, e.g. make sh c=nginx
	# stats             - show container stats, e.g. make stats c=nginx
	# up                - run docker-compose up
	# down              - run docker-compose down
	# composer          - run composer command
	# yarn              - run yarn command
	#
	###################################################################################
	@echo "Enjoy!"

.PHONY: conndb
conndb:
	docker run -it --rm --network=${NETWORK} ${MARIADB_IMG} bash -c "mysql -A --default-character-set=utf8 -h${MARIADB_NAME} -uroot -p${MARIADB_PASSWORD} onestep"

.PHONY: connredis
connredis:
	docker run --rm -it --net=${NETWORK} ${REDIS_IMG} redis-cli -h ${REDIS_NAME}

.PHONY: logs
logs:
	@docker logs -f --tail=30 onestep

.PHONY: network
network:
	docker network create -d bridge ${NETWORK} || true

.PHONY: pingdb
pingdb:
	@n=1; \
	while [ $${n} -eq 1 ]; \
	do \
		sleep 2s; \
		docker exec -it ${MARIADB_NAME} bash -c "mysql -u root -h 127.0.0.1 -p${MARIADB_PASSWORD} -e 'SELECT 1;'"; \
		n=$$?; \
	done;
	@make print m="maraidb is ready for use";

print:
	@printf '\x1B[32m%s\x1B[0m\n' "$$m"

.PHONY: prune
prune:
	@docker system prune -f

.PHONY: prune-data
prune-data:
	@docker system prune -f --volumes

.PHONY: ps
ps:
	docker ps -a

.PHONY: restart
restart:
	docker restart onestep

.PHONY: sh
sh:
	@if [ "$$c" == "" ]; then c=onestep; fi; \
	docker exec -it $$c bash

.PHONY: stats
stats:
	@if [ "$$c" == "" ]; then c=$$(docker ps -a | sed 1d | awk '{print $$NF}'); fi; \
	docker stats $$c

.PHONY: up
up: network
	docker-compose up -d
	make logs

.PHONY: down
down:
	docker-compose down

.PHONY: onestep
onestep: network
	docker-compose up -d onestep

.PHONY: onestep-down
onestep-down:
	docker-compose stop onestep
	docker-compose rm -f onestep

.PHONY: mariadb
mariadb: network
	docker-compose up -d mariadb

.PHONY: mariadb-down
mariadb-down:
	docker-compose stop mariadb
	docker-compose rm -f mariadb

.PHONY: yarn
yarn:
	@if [ "$$c" == "" ]; then c=prod; fi; \
	docker exec onestep yarn $$c

.PHONY: composer
composer:
	@if [ "$$c" == "" ]; then c=update; fi; \
	docker exec onestep composer $$c
