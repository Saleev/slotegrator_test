## Install Laravel ver.7
`composer create-project --prefer-dist laravel/laravel:^7.0 slotegrator`

## Preparing for launch
- Set database connection settings in the .env file 
- $ `composer require laravel/ui:^2.4`
- $ `php artisan ui:auth`
- copy all files from database/migration to $project_path/database/migration
- $ `php artisan migrate`

## Start Server
- $ `php artisan serve`

## Or Download project from github
- Create file .env
- Copy text from .env.example to file .env
- Set database connection settings in the .env file
- $ `php artisan migrate`
- $ `php artisan serve`

## Default admin
- Login: admin@game.com
- Password: 12345678
