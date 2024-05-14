# curd-laravel-kepegawaian

## 1
```sh
cd PROJECT
```
## 2. env
setup .env.example to .env
## 3. composer
```sh
sudo composer install
```
## 4. env setup
open .env then uncomment
```sh
# MEMCACHED_HOST=memcached
# CACHE_DRIVER=memcached
```
to
```sh
MEMCACHED_HOST=memcached
CACHE_DRIVER=memcached
```

## 5. Start the server
```sh
sudo ./vendor/bin/sail up
```

## 6. Migrations
Open new terminal
```sh
# Running up migrations after start the server
sudo ./vendor/bin/sail artisan migrate:fresh --seed
```
