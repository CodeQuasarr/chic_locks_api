##-------------------------VARIABLES-----------------------------##

CONSOLE = php artisan

##-------------------------COMMAND-------------------------------##

interface:
	@$(CONSOLE) make:interface Interfaces/$(name)

repository:
	@$(CONSOLE) make:class Repositories/$(name)

service:
	@$(CONSOLE) make:class Services/$(name)

trait:
	@$(CONSOLE) make:class Traits/$(name)

controller:
	@$(CONSOLE) make:controller Api/V1/$(name)

request:
	@$(CONSOLE) make:request $(name)

test:
	@$(CONSOLE) make:test $(name)

migration:
	@$(CONSOLE) make:migration $(name)

migrate:
	@$(CONSOLE) migrate

rollback:
	@$(CONSOLE) migrate:rollback

seed:
	@$(CONSOLE) db:seed

clear:
	@$(CONSOLE) cache:clear
    @$(CONSOLE) config:clear
    @$(CONSOLE) route:clear
    @$(CONSOLE) view:clear

command:
	@$(CONSOLE) make:command $(name)

model:
	@$(CONSOLE) make:model $(name)

##-------------------------HELP---------------------------------##

help:
	@echo "Usage: make [command] [name]"
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
	@echo "  command [name]         Create a new command"
	@echo "  model [name]           Create a new model"

##-------------------------PHONY---------------------------------##

.PHONY: interface repository service trait controller request test migration migrate rollback seed clear command model help

##-------------------------VARIABLES FOR NAMES-----------------##

name = $(word 2, $(MAKECMDGOALS))

##-------------------------DEFAULT TARGET----------------------##
default: help
