## Requirement to run the project
1. PHP minimum version 8.0
2. Composer
3. MySql
4. or use all in one php package like : XAMPP (PHP, MySql, Apache). make sure XAMPP minimum version : 8.0

## Step by step how to run 
1. open this project with your favorite code editor, e.g VSCode
2. run : composer install
3. copy .env.example and rename it .env
4. run : php artisan migrate
5. run : php artisan jwt:secret
6. run : php artisan serve
7. open postman to start exploring endpoints
