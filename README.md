# HUNGRY

## Restaurant searcher
for interview coding assignment

## Features

-   Search for restaurant
-   Make you hungry(maybe)

## Tech

Framwork that use in this project:

-   [VueJS] - as Frontend (version 2)
-   [Laravel] - as Backend (version 8)
-   [Vuesax] - framework components for VueJS
-   Database - nope

## Installation

Clone the repository

    git clone https://github.com/akaradat/hungry.git

Switch to the repo folder

    cd hungry

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file and add your `MAP_API_KEY`

    cp .env.example .env

Generate a new application key

    php artisan key:generate

## Docker

Suggest to use `LARADOCK`. Here is the [document](https://laradock.io/getting-started/).
Just only nginx is enough for this project.

[vuejs]: https://vuejs.org/
[laravel]: https://laravel.com/
[vuesax]: https://vuesax.com/
