<p align="center">Laravel+Vuex Starter</p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Admin Panel
This is an Starter project with Laravel and Vue.js (Vuex). It uses the folowing tech

    - Password encryption;
    - JWT using Laravel passport
    - Vuex
    - Namespacing
    - Base 64 image uploading
    - ACL (access-control list) using Laravel passport
    Also
    - Bootstrap 4
    - Scss


## Instalation

After cloning the repo: rename the .env.example to .env and add the credentials, run `php artisan key:generate` to generate a key and `php artisan passport:kets` to generate a key for JWT.

run `php artisan serve` and `npm run watch`
also run `php artisan storage:link` to use the photos
