.PHONY: install test run phpdoc composer-require-dev-dep composer-require-dev composer-require composer-dump-autoload

install:
	docker-compose run main composer install

test:
	docker-compose run main vendor/bin/pest

run:
	docker-compose run main php main.php

phpdoc:
	docker run --rm -v "./:/data" "phpdoc/phpdoc:3" -d src

composer-require-dev-dep:
	docker-compose run main composer require --dev $(package) --with-all-dependencies

composer-require-dev:
	docker-compose run main composer require --dev $(package)

composer-require:
	docker-compose run main composer require $(package)

composer-dump-autoload:
	docker-compose run main composer dump-autoload
