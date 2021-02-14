# salvemundi.nl-laravel

In order to get started:

Install [NPM/NodeJS](https://nodejs.org/en/) and [Composer](https://getcomposer.org/download/)

Set up a database. You can use something like [XAMPP](https://www.apachefriends.org/index.html) to accomplish this.
Create a database, and add a user that has full access to that database. Keep in mind that If you are using XAMPP's php,
You'll need to download an older version. Reason being php 7.4 is required and this project does not support php 8.0 yet.

Create an env file. The example env file should get you along the way.

If you don't want to run a webserver and database on your own computer you can also use [Docker](https://docs.docker.com/get-docker/).
I have made a Dockerfile that you will have to build first. However, you can just do: `docker compose up -d`.
That will startup the project, however this may take a while due to database seeding.

We are using [Microsoft Graph](https://docs.microsoft.com/en-us/graph/), therefore we have API tokens.
Meaning that a lot of functionality of the site is broken if you don't have Microsoft Graph api tokens.
However, if you are a part of the IT-commission of Salve Mundi we will trust you with these tokens.
Keep in mind that we are dealing with personal data, and the website should comply with GDPR.
P.S yes we shouldn't use production data in development but Microsoft Graph does not provide public test data via their API at this time.

In short: please don't commit sensitive/personal data into this public repo :)

Continuing:

In order to start up the project run the following inside the project root directory:

1. `composer install`
2. `npm install`
3. `npm run dev` or `npm run watch` (second option automatically re-compiles css when altering css/scss files)
4. `php artisan storage:link`
5. `php artisan migrate`
6. `php artisan db:seed`
7. `php artisan serve`

If you are using docker, step 4,5,6 & 7 can be ignored.

Thanks for reading!

Made by: IT-Commission Salve Mundi
