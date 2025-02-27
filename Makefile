##-------------------------VARIABLES-----------------------------##

CONSOLE = php artisan
ARGS = $(wordlist 2, $(words $(MAKECMDGOALS)), $(MAKECMDGOALS))

##-------------------------COMMAND-------------------------------##

interface:
	$(CONSOLE) make:interface Interfaces/$(ARGS)

repository:
	$(CONSOLE) make:class Repositories/$(ARGS)

service:
	$(CONSOLE) make:class Services/$(ARGS)

trait:
	$(CONSOLE) make:class Traits/$(ARGS)

controller:
	$(CONSOLE) make:controller Api/V1/$(ARGS)

request:
	$(CONSOLE) make:request $(ARGS)

test:
	$(CONSOLE) make:test $(ARGS)

migration:
	$(CONSOLE) make:migration $(ARGS)

migrate:
	$(CONSOLE) migrate

rollback:
	$(CONSOLE) migrate:rollback

seed:
	$(CONSOLE) db:seed

clear:
	$(CONSOLE) cache:clear
	$(CONSOLE) config:clear
	$(CONSOLE) route:clear
	$(CONSOLE) view:clear
##-------------------------HELP---------------------------------##

help:
	@echo "Usage: make [command]"
	@echo ""
	@echo "Available commands:"
	@echo "  interface [name]       Create a new interface"
	@echo "  repository [name]      Create a new repository"
	@echo "  service [name]         Create a new service"
	@echo "  trait [name]           Create a new trait"
	@echo "  controller [name]      Create a new controller"
	@echo "  request [name]         Create a new request"
	@echo "  test [name]            Create a new test"
	@echo "  migration [name]       Create a new migration"
	@echo "  migrate                Run the database migrations"
	@echo "  rollback               Rollback the last database migration"
	@echo "  seed                   Seed the database with records"
	@echo "  clear                  Clear the cache, config, route and view"
	@echo "  help                   Display this help message"
	@echo ""
##-------------------------PHONY---------------------------------##
## Empêche Make d’interpréter les arguments comme des cibles
.PHONY: interface repository service trait controller request test
