.PHONY: all install start stop terminal

all: install start stop terminal

install:
	docker-compose -f ./docker/docker-compose.yml up -d --build

start:
	docker-compose -f ./docker/docker-compose.yml up -d

stop:
	docker-compose -f ./docker/docker-compose.yml down

terminal:
	docker-compose -f ./docker/docker-compose.yml exec php bash