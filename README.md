<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## How to use this backend?

Follow the instruction below:

## Clone the repo from Github

Run this in the folder that you wish to set up the project:
git clone https://github.com/leezyangg/vemdora-backend.git
Then run cd <repo_folder>

### Set up .env file and configuration

In project's directory RUN :
MacOS: mv .env.example .env
Windows: copy .env.example .env

Open .env file, configure database to your local MySql settings

## Generate a new application key:

php artisan key:generate

## Install the project dependencies using Composer:

composer install

## Set Up Database table by running migration

php artisan migrate

If you want to drop all tables and remigrate:
php artisan migrate

## Seeding(create) mock up data

To check the seeder class name, go to /database/seeders
php artisan db:seed <seeder_class_name>

## Starting Laravel developer server

php artisan serve

[Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
