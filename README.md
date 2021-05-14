<p align="center"><img src="https://codeigniter.com/assets/images/codeigniter4logo.png" width="200"></p>

<p align="center">
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://poser.pugx.org/hamkamannan/adminigniter/version"></a>
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://img.shields.io/badge/Package-agungsugiarto%2Fadminigniter-light.svg"></a>
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://poser.pugx.org/hamkamannan/adminigniter/downloads"</img></a>
<a href="https://github.com/hamkamannan/adminigniter/blob/master/LICENSE.md"><img src="https://img.shields.io/github/license/hamkamannan/adminigniter"></a>
</p>


Adminigniter
=====================================
Complete Authentication and Authorization system for CodeIgniter4 HMVC with Premium Admin LTE.

Feature
-------
* Configurable backend theme [Admin Dashboard Template](https://dashboardpack.com/)
* CSS framework [Bootstrap 4](https://getbootstrap.com/)
* Icons by [Font Awesome 5](https://fontawesome.com/)
* Role-based permissions (RBAC) provided by [Myth/Auth](https://github.com/lonnieezell/myth-auth)
* Dynamically-Generated Menu
* Localized English / Indonesian

This project is still early in its development... please feel free to contribute!
------------------------------------------------------------
Screenshoot | Demo On [Mannan](https://mannan.id/)
-------------------------------------------------------------------------------
![Dashboard](.github/dashboard.png?raw=true)

Installation
------------

**1.** Get The Module, since the myth/auth packages is still under development, we need to change composer.json in root project directory. Open composer.json with your text editor and add code like [this](https://github.com/hamkamannan/adminigniter/blob/master/composer.json#L29-L30), or below like this.

```bash
"minimum-stability": "dev",
"prefer-stable": true,
```

And run require via composer

```bash
composer require hamkamannan/adminigniter
```

**2.** Set CI_ENVIRONMENT, baseURL, index page, and database config in your `.env` file based on your existing database (If you don't have a `.env` file, you can copy first from `env` file: `cp env .env` first). If the database does not exist, create the database first.

```bash
# .env file
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080'
app.indexPage = ''

database.default.hostname = localhost
database.default.database = adminigniter
database.default.username = root
database.default.password = root
database.default.DBDriver = MySQLi
```
**3.** Run publish auth
```bash
php spark auth:publish

Publish Migration? [y, n]: y
  created: Database/Migrations/2017-11-20-223112_create_auth_tables.php
  Remember to run `spark migrate -all` to migrate the database.
Publish Models? [y, n]: n
Publish Entities? [y, n]: n
Publish Controller? [y, n]: n
Publish Views? [y, n]: n
Publish Filters? [y, n]: n
Publish Config file? [y, n]: y
  created: Config/Auth.php
Publish Language file? [y, n]: n
```

> NOTE: Everything about how to configure auth you can find add [Myth/Auth](https://github.com/lonnieezell/myth-auth).


Is it ready yet? Not so fast!! ;-) After publishing `Config/Auth.php` you need to change
`public $views` with these lines below:
```php
public $views = [
    'login'           => 'hamkamannan\adminigniter\Views\Authentication\login',
    'register'        => 'hamkamannan\adminigniter\Views\Authentication\register',
    'forgot'          => 'hamkamannan\adminigniter\Views\Authentication\forgot',
    'reset'           => 'hamkamannan\adminigniter\Views\Authentication\reset',
    'emailForgot'     => 'hamkamannan\adminigniter\Views\Authentication\emails\forgot',
    'emailActivation' => 'hamkamannan\adminigniter\Views\Authentication\emails\activation',
];
```

Open `app\Config\Filters.php`, find `$aliases` and add these lines below:
```php
public $aliases = [
    'login'      => \Myth\Auth\Filters\LoginFilter::class,
    'role'       => \hamkamannan\adminigniter\Filters\RoleFilter::class,
    'permission' => \hamkamannan\adminigniter\Filters\PermissionFilter::class,
];
```

**4.** Run publish, migrate and seed adminigniter

```bash
php spark adminigniter:install
```

**5.** Run development server:

```bash
php spark serve
```

**6.** Open in browser http://localhost:8080/admin
```bash
Default user and password
+----+--------+-------------+
| No | User   | Password    |
+----+--------+-------------+
| 1  | admin  | password    |
| 2  | user   | password    |
+----+--------+-------------+
```

Usage
-----
You can find how it works with the read code routes, controller and views etc. Finnally... Happy Coding!

Changelog
--------
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

Contributing
------------
Contributions are very welcome.

License
-------

This package is free software distributed under the terms of the [MIT license](LICENSE.md).

