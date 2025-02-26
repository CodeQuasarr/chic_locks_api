##-------------------------VARIABLES-----------------------------##

CONSOLE = php artisan
ARGS = $(filter-out $@,$(MAKECMDGOALS))

##-------------------------COMMAND-------------------------------##

controller:
	$(CONSOLE) make:controller $(ARGS)

request:
	$(CONSOLE) make:request $(ARGS)

test:
	$(CONSOLE) make:test $(ARGS)

## Empêche Make d’interpréter les arguments comme des cibles
.PHONY: controller request test
