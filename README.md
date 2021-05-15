<p align="center"><img src="https://codeigniter.com/assets/images/codeigniter4logo.png" width="200"></p>

<p align="center">
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://poser.pugx.org/hamkamannan/adminigniter/version"></a>
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://img.shields.io/badge/Package-hamkamannan%2Fadminigniter-light.svg"></a>
<a href="https://packagist.org/packages/hamkamannan/adminigniter"><img src="https://poser.pugx.org/hamkamannan/adminigniter/downloads"</img></a>
<a href="https://github.com/hamkamannan/adminigniter/blob/master/LICENSE.md"><img src="https://img.shields.io/github/license/hamkamannan/adminigniter"></a>
</p>


Adminigniter
=====================================
Complete Authentication and Authorization system for CodeIgniter4 HMVC with Premium Admin LTE.

Feature
-------
* Configurable backend theme [Premium Admin LTE](https://dashboardpack.com/)
* CSS framework [Bootstrap 4](https://getbootstrap.com/)
* Icons by [Font Awesome 5](https://fontawesome.com/)
* Role-based permissions (RBAC) provided by [Myth/Auth](https://github.com/lonnieezell/myth-auth)
* Dynamically-Generated Menu (Drag n Drop)
* Localized English / Indonesian

NOTE: This library was inspired from [agungsugiarto/boilerplate](https://packagist.org/packages/agungsugiarto/boilerplate)

Please feel free to contribute!
------------------------------------------------------------
Screenshoot | Demo On [mannan.id](https://mannan.id/)
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

**3.** Run publish, migrate and seed adminigniter
```bash
php spark adminigniter:publish

Publish Database Migration? [y, n]: y
  created: Database/Migrations/20210101_000000_Auth
  created: Database/Migrations/20210101_000001_AuthAlterUser
  created: Database/Migrations/20210101_000002_Adminigniter
Publish Database Seed? [y, n]: y
  created: Database/Seeds/AdminigniterSeeder.php
Copy Public Assets? [y, n]: y
  created: public/assets/*
  created: public/themes/*
Copy Libraries? (Adminigniter Libraries/DataTables) [y, n]: y
  created: Libraries/DataTables//Utilities/*
  created: Libraries/DataTables/*
Patch View for HMVC? [y, n]: y
  created: vendor/codeigniter4/framework/system/View/View.php
```

```bash
php spark migrate

  Running: (App) 20210101_000000_App/Database/Migrations/Auth
  Running: (App) 20210101_000001_App/Database/Migrations/AuthAlterUsers
  Running: (App) 20210101_000002_App/Database/Migrations/Adminigniter
```

```bash
php spark db:seed AdminigniterSeeder

  Seeded: App\Database\Seeds\AdminigniterSeeder
```

**4.** Configuration
> NOTE: Everything about how to configure auth you can find add [Myth/Auth](https://github.com/lonnieezell/myth-auth).


Open `app/Config/Auth.php` find `public $views` and changes with these lines below:
```php
public $views = [
  'login'           => 'hamkamannan\adminigniter\Views\auth\login',
  'register'        => 'hamkamannan\adminigniter\Views\auth\register',
  'forgot'          => 'hamkamannan\adminigniter\Views\auth\forgot',
  'reset'           => 'hamkamannan\adminigniter\Views\auth\reset',
  'emailForgot'     => 'hamkamannan\adminigniter\Views\auth\emails\forgot',
  'emailActivation' => 'hamkamannan\adminigniter\Views\auth\emails\activation',
];
```

Open `app/Config/Auth.php` find `variables` and changes with these lines below:
```php
public $defaultUserGroup = 'user';
public $allowRegistration = true;
public $requireActivation = false; 
public $activeResetter = false;
public $allowRemembering = true;
```

Open `app/Config/Auth.php` find `public $passwordValidators` and changes with these lines below:
```php
public $passwordValidators = [
  'Myth\Auth\Authentication\Passwords\CompositionValidator',
  'Myth\Auth\Authentication\Passwords\NothingPersonalValidator',
  'Myth\Auth\Authentication\Passwords\DictionaryValidator',
  'Myth\Auth\Authentication\Passwords\PwnedValidator',
];
```

Open `app/Config/Filters.php`, find `$aliases` and add these lines below:
```php
public $aliases = [
  'login'         => \Myth\Auth\Filters\LoginFilter::class,
  'role'          => \hamkamannan\adminigniter\Filters\RoleFilter::class,
  'permission'    => \hamkamannan\adminigniter\Filters\PermissionFilter::class,
];
```

Open `app/Config/Autoload.php`, find `$psr4` and add these lines below:
```php
public $psr4 = [
	APP_NAMESPACE   => APPPATH, // For custom app namespace
	'App'           => APPPATH,
	'Config'        => APPPATH . 'Config',
	'DataTables'    => APPPATH .'Libraries/DataTables',
];
```

**5.** Run development server:

```bash
php spark serve
```

**6.** Open in browser http://localhost:8080/dashboard
```bash
Default user and password
+----+--------+-------------+
| No | User   | Password    |
+----+--------+-------------+
| 1  | admin  | qwerty!@#   |
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

