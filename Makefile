DUMPFILE?=seed.sql
CRAFT_BIN?=php craft
COMPOSER_BIN?=composer

.PHONY: update

update:
	${COMPOSER_BIN} update
	${CRAFT_BIN} db/restore ${DUMPFILE}
	${CRAFT_BIN} migrate/all
	${CRAFT_BIN} project-config/apply --force
	${CRAFT_BIN} queue/run
	${CRAFT_BIN} gc --delete-all-trashed
	${CRAFT_BIN} db/backup ${DUMPFILE} --overwrite
	git add ${DUMPFILE} composer.lock config/project
	git commit -m "Update Composer & seed data."
