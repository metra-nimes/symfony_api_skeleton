DOCKER_COMPOSE=docker-compose

all: # all
	@echo do nothing

dev: # run dev server
	$(DOCKER_COMPOSE) up --remove-orphans

test: # run tests
	$(DOCKER_COMPOSE) exec php bash phptest.sh

destroy: # destroy containers
	$(DOCKER_COMPOSE) down
	sudo rm -fr data