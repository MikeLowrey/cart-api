## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## About Olá ##

Olá is an result of an Coding Challenge from the Company **asgoodasnew**. The Task was: 

Build a simple REST API of a shopping cart in PHP and ideally implemented in Symfony.

The API should be RESTful and provide the following functions. 

- Add an item to the shopping cart.
- Delete an item from the shopping cart.
- Edit an item in the shopping cart.
- Display the shopping cart.

## My approach: ##
- Backend in Laravel ~8 
- Frontend Vue ~2
- Environment: 
    - Server: nginx,
    - PHP: 8
    - Database: Sqlite
    - Style: TailwindCSS

For more information see **docker-compose.yml** in the root Folder.


## Steps to get the application running. ##
1. check if Docker Compose is installed on your local machine.

    `docker-compose -v` (**is required**)

2. clone/pull the repository from GitHub

    `git clone xxx.git`

3. go into the application folder

    `cd application`

4. start Docker Compose with:

    `docker-compose up -d`

5. check if containers are mounted

    `docker ps`

    **Output:**




CONTAINER ID | IMAGE | COMMAND | CREATED | STATUS | PORTS | NAMES
-------------|-------|---------|---------|--------|-------|------
98792c791499 | nginx:alpine | "/docker-entrypoint.…" | x minute ago | Up x minutes | 0.0.0.0:8000->80/tcp, :::8000->80/tcp |  laravel-api-nginx 
77495767ea21 | laravel-app | "docker-php-entrypoi…" | x minutes ago |  Up x minutes | 9000/tcp | laravel-api-app


6. enter the laravel-api-app container with: 

    a) `docker exec -it laravel-api-app bash`

    b) `cd application`

7. install all laravel dependencies

    `composer install`

8. create a SQLITE Database with:

    `touch database/database.sqlite`

9. start database migration with:

    `php artisan migrate:refresh --seed`

10. install all VueJS dependencies with: 

    `npm install`

The application should now be accessible under http://127.0.0.1:8000.

## To run the Tests ##
You can run the Tests inside the laravel-api-app. Navigate to the application Folder and Start the Test with: 
`php artisan test` = PHPUnit
`npx cypress open` = Cypress

## Run PHP Codesnifer ##
Rules define in file ./phpcs.xml
`./vendor/bin/phpcs ./ --colors`
Some code fixes can be fix automatically by applying `./vendor/bin/phpcbf`

## Run PHPStan ##
For example: `vendor/bin/phpstan analyze -c phpstan.neon`

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Olá Shoppingcart from Martin Sejka

