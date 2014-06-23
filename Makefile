test: lint phpcs phpunit behat

lint:
	php -l web/index.php
	for f in `find src -name *.php`; do php -l $$f; done
	for f in `find test -name *.php`; do php -l $$f; done
	for f in `find features -name *.php`; do php -l $$f; done

phpcs:
	./vendor/bin/phpcs --standard=PSR2 --ignore=vendor,coverage,ckeditor,blog .

phpunit:
	if [ -e test ]; then cd test && ../vendor/bin/phpunit .; fi

behat: db-setup
	./vendor/bin/behat

test-cyg: lint phpcs-cyg phpunit-cyg behat-cyg

phpcs-cyg:
	./vendor/bin/phpcs.bat --standard=PSR2 --ignore=vendor,coverage,ckeditor,blog .

phpunit-cyg:
	if [ -e test ]; then cd test && ../vendor/bin/phpunit.bat .; fi

behat-cyg: db-setup
	./vendor/bin/behat.bat

test-ci: lint phpcs phpunit behat-ci

behat-ci:
	./vendor/bin/behat --profile=ci

db-setup:
	mysql -u ${MYSQL_USER} -p -h 127.0.0.1 < ./test/scripts/db/makefile-test-script.sql
	