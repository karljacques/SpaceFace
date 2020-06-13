# Quick Start

This project has a separate front end and backend.

First, clone the repository.

Secondly, you will need to install Docker + Node.

## Backend

In the root folder, run the following command to boot all the containers:
```
docker-compose up -d
```

Composer install
```
./bin/composer install
```

After doing a composer install, you _may_ need to restart the containers - it's a bit flakey due to the way Swoole reboots itself.

```
docker-compose down
docker-compose up -d
```

Generate keys for JWT using passphrase in `.env JWT_PASSPHRASE`
```
./bin/generate-keys
```

Run migrations on the database:
```
./bin/console doctrine:migrations:migrate
```

Seed the database with test data:
```
./bin/console doctrine:fixtures:load
```

## Front end

Navigate to FE folder
```
cd ./web-client
```

```
npm install
```

```
npm run serve
```

Now you should be able to navigate to `localhost:8080` and play!
