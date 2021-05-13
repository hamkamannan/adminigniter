# Adminigniter
Complete Authentication and Authorization system for CodeIgniter4 HMVC with Premium Admin LTE.

**Coming soon, a feature such as CRUD generator, Rest API Builder, and Page Builder**

## Server Requirements
Composer is required.
- [composer](https://getcomposer.org/download/)

PHP version 7.2 or higher is required, with the following extensions installed: 
- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:
- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Installation 

### Manual Installation
Clone from [Adminigniter GitHub](https://github.com/hamkamannan/adminigniter.git)

```
$ git clone https://github.com/hamkamannan/adminigniter.git
$ composer install
$ composer update
```

### Composer Installation
Running composer command 

```
$ composer create-project hamkamannan/adminigniter:dev-master
```

## Setup Environmnt
- Setup your environment (.env) by clone file env

```
$ cd adminigniter 
$ cp env .env
$ vi .env
```

- Set to development mode for showing debug information

```
CI_ENVIRONMENT = development
```

- Custom the Database Config for **MySQL**

```
# mysql
database.default.hostname = 127.0.0.1
database.default.database = adminigniter
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
```

- Custom the Database Config for **PostgreSQL**

```
# postgre
database.default.DSN = pgsql:host=127.0.0.1;port=5432;dbname=postgres
database.default.database = 
database.default.username = postgres
database.default.password = postgres
database.default.DBDriver = postgre
```

- Migration

```
$ cd adminigniter
$ php spark migrate
```

- Seed

```
$ cd adminigniter
$ php spark db:seed Init
```

If there is error on running Seeding, execute this command, below and repeat again on step Migration

```
$ cd adminigniter
$ php spark migrate:rollback
```

- Patch for HMVC

```
$ cd adminigniter
$ cp patch/View.php vendor/codeigniter4/framework/system/View/
```

## Run Application

```
$ cd adminigniter
$ php spark serve
```

Voila! **Adminigniter** started on http://localhost:8080


Changes Log
----
 
### Version 1.0 (May 11, 2021)

```
 - Release of this script
 ```

Author
----

**Hamka Mannan (hamka@mannan.id) - https://mannan.id**

