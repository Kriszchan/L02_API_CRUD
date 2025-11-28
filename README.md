php artisan install:api

php artisan make:model Task --api -m -f


php artisan migrate
php artisan db:seed

php artisan make:resource TaskResource
