
## URL Shortener

- php: ^8.0
- postgres: ^14.0
- laravel/framework: ^9.0

### Installation Steps
- git clone
- composer install
- edit env
- php artisan jwt:secret
- php artisan migrate --seed
- php artisan queue:work
