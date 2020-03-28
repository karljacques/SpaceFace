docker-compose run --no-deps php rm var/test.db3
docker-compose run --no-deps php bin/console doctrine:schema:create --env=test
