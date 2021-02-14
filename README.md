![CI](https://github.com/salvemundi/salvemundi.nl-laravel/workflows/CI/badge.svg)

## salvemundi.nl-laravel

In order to get started:

Install [NPM/NodeJS](https://nodejs.org/en/) and [Composer](https://getcomposer.org/download/)

Set up a database. You can use something like [XAMPP](https://www.apachefriends.org/index.html) to accomplish this.
Create a database, and add a user that has full access to that database. PHP-8.0 is officially supported.

Create an env file. The example env file should get you along the way.

In order to start up the project run the following inside the project root directory:

1. `$ composer install`
2. `$ npm install`
3. `$ npm run dev` or `$ npm run watch` (second option automatically re-compiles css when altering css/scss files)
4. `$ php artisan storage:link`
5. `$ php artisan migrate`
6. `$ php artisan db:seed`
7. `$ php artisan serve`

If you are using docker, step 4,5,6 & 7 can be ignored.

# Docker

If you don't want to run a webserver and database on your own computer you can also use [Docker](https://docs.docker.com/get-docker/).
I have made a Dockerfile that you will have to build first. Before starting up docker, make sure that the database host is set to `db` in your .env file.


## Method 1 - Taskfile

If you are on a unix (Macos / Pretty much any linux distro) like system. You can use the [Taskfile](https://taskfile.dev).

Commands:
- `$ task w:prep`
    - Prepare dev environment (composer install, npm run)

- `$ task d:up`
    - Startup docker containers

- `$ task d:down`
    - Shutdown docker containers

- `$ task d:build`
    - (re-)build docker containers

- `$ task w:db:migrate`
    - Run pending migrations

- `$ task w:db:reset`
    - Reset database

## Method 2 - Manually

If for some reason you are using windows, make sure the `docker-start.sh` file is executable.
When still getting permission denied errors for `docker-start.sh` then you may also set the permission correctly inside of the docker-container.
- `$ docker exec -it app bash`
- `$ chmod +X docker-start.sh`

After that is done `$ docker-compose up -d` can be ran and should work fine from here on. If not, please also read the [Api](#Api's) segment.

That will startup the project, however this may take a while due to database seeding.


# Api's

## Microsoft graph

We are using [Microsoft Graph](https://docs.microsoft.com/en-us/graph/), therefore we have API tokens.
Meaning that a lot of functionality of the site is broken if you don't have Microsoft Graph api tokens.
However, if you are a part of the IT-commission of Salve Mundi we will trust you with these tokens.
Keep in mind that we are dealing with personal data, and the website should comply with GDPR.
P.S yes we shouldn't use production data in development but Microsoft Graph does not provide public test data via their API at this time.

## Mollie
As for our payment system, [Mollie](https://mollie.com). This api key is only available to the development server. Reason being since Mollie uses webhooks in order to communicate payment status updates, the host sending the payment request needs to publicly available. Therefore you can't test mollie payments from your localhost under default circumstances.

---

P.S please don't commit sensitive/personal data into this public repo :)

Thanks for reading!

Made by: IT-Commission Salve Mundi

![alt text](./storage/app/public/images/SalveMundi-Vector.svg)
