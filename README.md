# Test Parser
## Dependencies

* Redis must be installed
* [phpredis](https://github.com/phpredis/phpredis) PHP extension must be installed

## Project setup

Copy .env, change required settings

```
cp .env.example .env
```

Set up in .env Db settings, Redis settings.
Set PARSER_CRON_TIME in CRON expression

Install composer deps, generate key

```
composer update && php artisan key:generate
```

Migrate database

```
php artisan migrate
```

Run queue worker

```
php artisan queue:work
```


Add Laravel Scheduler Cron entry to your server ([Running The Scheduler](https://laravel.com/docs/8.x/scheduling#running-the-scheduler)) or run command locally:

```
php artisan schedule:work
```

