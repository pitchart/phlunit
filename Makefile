### Variables

# Applications
COMPOSER ?= composer

### Helpers
all: clean depend

.PHONY: all

### Dependencies
depend:
	${COMPOSER} install --no-progress --optimize-autoloader

.PHONY: depend

### Cleaning
clean:
	rm -rf vendor

git-master:
	git checkout master

.PHONY: clean git-master

### QA
qa: lint fixer psalm

lint:
	find ./src -name "*.php" -exec /usr/bin/env php -l {} \; | grep "Parse error" > /dev/null && exit 1 || exit 0

coding-style:
	php vendor/bin/php-cs-fixer fix --dry-run

psalm:
	php vendor/bin/psalm

fixer:
	php vendor/bin/php-cs-fixer fix

.PHONY: qa lint coding-style psalm fixer

### Testing
tests:
	php vendor/bin/phpunit

tests-report:
	php vendor/bin/phpunit --coverage-html ./qa/coverage/

.PHONY: tests tests-report
