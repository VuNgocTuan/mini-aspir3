# Aspire Mini-API

The projects help users to create & manage loan applications.

## Requirement
1. Docker.
2. PHP & Composer
3. Laravel 8
4. VSCode

## Installation

1. .env

```bash
git submodule init && git submodule update
cp .env-laradock.example /laradock/.env
cp .env.dev .env
```

2. Laradock build & run

```bash
cd laradock/
docker-compose build nginx mariadb workspace php-fpm
docker-compose update -d nginx mariadb
```

3. Composer install
```bash
cd laradock/
docker-compose exec --user=laradock workspace bash 
composer install
php artisan migrate
```

After containers up, open [http://localhost](http://localhost) to test.

4. Users test

```bash
User: harley@example.com/1234@5678
Banker User: banker-staff01@aspiredev.com/1234@5678
```

5. Create Testing database
```bash
//Create db test
cp createdb-testing.sql laradock/mariadb/docker-entrypoint-initdb.d/
```

```bash
cd laradock && docker-compose exec mariadb bash
mysql -u root -p < /docker-entrypoint-initdb.d/createdb-testing.sql
Enter root password: root
```

## Docs

1. Postman (.json): /postman/*.json.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)