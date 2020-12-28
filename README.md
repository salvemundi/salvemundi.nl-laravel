# salvemundi.nl-laravel

In order to get started:

Install [NPM/NodeJS](https://nodejs.org/en/) and [Composer](https://getcomposer.org/download/)

Set up a database. You can use something like [XAMPP](https://www.apachefriends.org/index.html) to accomplish this.
Create a database, and add a user that has full access to that database.

Create an env file. The example env file should get you along the way.

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
7. `php artisan db:seed`
6. `php artisan serve`

Thanks for reading!

Made by: IT-Commission Salve Mundi
