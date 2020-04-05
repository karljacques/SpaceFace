docker-compose run --no-deps php-swoole rm var/test.db3
docker-compose run --no-deps php-swoole bin/console doctrine:schema:create --env=test
