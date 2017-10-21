DOCKER = docker run --privileged -v $(shell pwd):/app crash sh -c
export PROTOBUF_VERSION=3.5.1

all:
	docker build --build-arg PROTOBUF_VERSION=$(PROTOBUF_VERSION) -t crash .
	$(DOCKER) 'make proto'
	$(DOCKER) 'make composer'
	@echo
	@echo With C extension
	-@$(DOCKER) 'php -d extension=protobuf.so vendor/bin/phpunit src/CrashTest.php'
	@echo
	@echo Without C extension
	-@$(DOCKER) './vendor/bin/phpunit src/CrashTest.php'

composer:
	sed -e 's/##PROTOBUF_VERSION##/$(PROTOBUF_VERSION)/' composer.json.tmpl > composer.json
	php composer.phar install

proto:
	mkdir -p gen-proto
	protoc --php_out gen-proto crash.proto
