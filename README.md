
![alt text](/public/images/logo_old.svg)

# Read Me!

## Docker

If you don't want to run a webserver and database on your own computer you may use [Docker](https://docs.docker.com/get-docker/). Make sure that the database host is set to `db` in your .env file.

If you have Docker installed on your machine, you may use [Laravel Sail](https://laravel.com/docs/10.x/sail) to run various Docker containers for local
development. By default, port 80 is used for the web server, making the application reachable on `http://localhost` in your browser.

> WARNING: For Windows users it is HIGHLY recommended to use WSL for running this application.

Commands:
- Laravel sail is installed using PHP, to install it without having PHP on your machine, run the following command:
  - ```
    $ docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
    ```
  - This will install all the PHP dependencies by temporarily spinning up a docker container.


- Then start the docker containers (run this command in the root of the project directory)
  - `./vendor/bin/sail up -d`

- Configure NPM
  - `./vendor/bin/sail npm install`
  - `./vendor/bin/sail npm run dev`

- Configure database and storage
  - `./vendor/bin/sail artisan storage:link`
  - `./vendor/bin/sail artisan key:generate`
  - `./vendor/bin/sail artisan migrate`
  - `./vendor/bin/sail artisan db:seed`

- Stop the containers:
  - `./vendor/bin/sail down`

To run Artisan commands, use `./vendor/bin/sail artisan`. For more information, view
the [Sail documentation](https://laravel.com/docs/8.x/sail#executing-sail-commands).

An alias may be set for ease of use in  your .bashrc / .zshrc file.

`alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`

## Bare metal

Install [NPM/node.js](https://nodejs.org/en/) and [Composer](https://getcomposer.org/download/)

> ⚠ For PHP: Please ensure the imagick module is installed and enabled. Image generation will fail without it!

Set up a database. You can use something like [XAMPP](https://www.apachefriends.org/index.html) to accomplish this, or read down below for
instructions on setting up a local development environment using Docker. Create a database, and add a user that has full access to that database.
PHP-8.2 is officially supported.

Create an environment (`.env`) file. The example `.env.example` file should get you along the way. To generate a key to be used for encrypting and
decrypting data, run the following command in your terminal:
> php artisan key:generate

In order to start up the project run the following inside the project root directory:

1. `$ composer install`
2. `$ npm install`
3. `$ npm run dev` or `$ npm run watch` (second option automatically re-compiles css when altering css/scss files)
4. `$ php artisan storage:link`
5. `$ php artisan migrate`
6. `$ php artisan db:seed` (this will take a couple of minutes)
7. `$ php artisan serve`

# APIs

The website is dependent on a couple of APIs which have been listed below.

## Microsoft graph

We are using [Microsoft Graph](https://docs.microsoft.com/en-us/graph/), this links all the users with their office account in the Office 365 tenant. For development purposes we are using a separate tenant to do our testing and development. A lot of the functionality is broken when this API is not setup properly in the `.env` file.

## Mollie

As for our payment system, [Mollie](https://mollie.com). We have a test API key used for development which will let us return any payment status we desire. If you are a member of the IT committee, you will receive a test token for development. You may use [Ngrok](https://ngrok.com/) to tunnel your traffic from your local host to the public temporarily so that [Mollie](https://mollie.com) can send webhooks back to your development environment.

## Salve Mundi API

A link has been created between the [introduction system](https://github.com/salvemundi/intro-application) and the main Salve Mundi website. Laravel passport is used to authenticate the introduction system to the Salve Mundi API hosted in this project. This API currently supports creating one time use coupons, and creating new users. For more details you can find the routes in the routes/api.php file that are using the "client_credentials" middleware.

Also, the minecraft server is linked using a [custom written plugin](https://github.com/salvemundi/whitelist-plugin) to update the whitelist based on the minecraft names the members have given us via the website.

---

PS. Please don't commit sensitive/personal data into this public repo :)

Thanks for reading!

Made by: The IT Committee of Salve Mundi
