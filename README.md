# salvemundi.nl-laravel

In order to start this project:

Install [NPM/NodeJS](https://nodejs.org/en/) and [Composer](https://getcomposer.org/download/)

Setup a database. You can use something like XAMPP to accomplish this.
Create a database and a user that has full access to that database.

Create an env file. The example env file should get you along the way.

We are using [Microsoft Graph](https://docs.microsoft.com/en-us/graph/), therefore we have API tokens.
Meaning that alot functionality of the site is broken if you don't have Microsoft Graph api tokens.
If you are a part of the IT-commission of Salvemundi we will trust you with these tokens.
Keep in mind that we are dealing with personal data and the website should comply with GDPR.
And yes we shouldn't use production data in development but Microsoft Graph doesn't provide public test data via their API at this time.

In short: please don't commit sensitive/personal data into this public repo :)

Continuing:

In order to start up the project run the following in side of the project root directory:

1. `composer install`
2. `npm install`
3. `npm run dev` or `npm run watch` (second option re-compiles css when altering css/scss files)
4. `php artisan storage:link`
5. `php artisan migrate`
6. `php artisan serve`

Thanks for reading!
Made by: IT-Commission Salve Mundi
