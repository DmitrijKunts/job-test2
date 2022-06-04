# Тестовое задание

Реализация REST API

## В .env

REST_API_URL=http://localhost:8001/api/v1

TINYPNG_API_KEY="TR57H0kx5rLrYmC4mvY41NZh2GZgYXVb"


php artisan migrate --seed

php artisan storage:link

php artisan test 

## Рабочая копия в WEB

### REST API

https://jobtest2.codelockerlab.com/api/v1

GET https://jobtest2.codelockerlab.com/api/v1/token

GET https://jobtest2.codelockerlab.com/api/v1/users

POST https://jobtest2.codelockerlab.com/api/v1/users

GET https://jobtest2.codelockerlab.com/api/v1/users/{id}

GET https://jobtest2.codelockerlab.com/api/v1/positions


### WEB-интерфейс

https://jobtest2.codelockerlab.com/
