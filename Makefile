DUMPFILE?=seed.sql
PHP_BINARY?=php
COMPOSER_BINARY?=composer

.PHONY: update

update:
	${COMPOSER_BINARY} update
	${PHP_BINARY} craft db/restore ${DUMPFILE}
	${PHP_BINARY} craft migrate/all
	${PHP_BINARY} craft project-config/apply --force
	git add ${DUMPFILE} composer.lock config/project
	git commit -m "Update Composer & seed data."
