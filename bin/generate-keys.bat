docker-compose run --no-deps php-swoole mkdir -p config/jwt
docker-compose run --no-deps php-swoole openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
docker-compose run --no-deps php-swoole openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
