##-------------------------VARIABLES-----------------------------##

CONSOLE = php artisan
ARGS = $(filter-out $@,$(MAKECMDGOALS))

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

## Empêche Make d’interpréter les arguments comme des cibles
.PHONY: controller request test
