DUMPFILE ?= seed.sql
EXEC ?= docker compose exec -T web
RUN ?= docker compose run --rm web
WEB_CONTAINER = docker compose ps -q web

.PHONY: init update restore backup seed clean test

init:
	cp .env.docker .env
	docker compose up -d
	${EXEC} composer install
update:
	${EXEC} composer update --no-interaction
	${EXEC} php craft up --interactive=0
	${EXEC} php craft queue/run --interactive=0
	${EXEC} php craft gc --delete-all-trashed --interactive=0
restore:
	${EXEC} php craft db/restore ${DUMPFILE}
backup:
	${EXEC} php craft db/backup ${DUMPFILE} --overwrite --interactive=0
	docker cp $(shell ${WEB_CONTAINER}):/app/composer.lock ./
	docker cp $(shell ${WEB_CONTAINER}):/app/seed.sql ./
	docker cp $(shell ${WEB_CONTAINER}):/app/config/project ./config/
seed:
	${EXEC} php craft demos/seed
clean:
	${EXEC} php craft demos/seed/clean
test:
	${EXEC} curl -IX GET --fail http://localhost:8080/actions/app/health-check
	${EXEC} curl -IX GET --fail http://localhost:8080/
update_and_reseed: init restore update clean seed backup
