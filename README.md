#Setup intructions
1. `cp .env.example .env`
2. Insert currencylayer api key into .env file `CURRENCY_LAYER_API_KEY` field in .env
3. Insert a admin password into the .env `ADMIN_PASSWORD` field
4. `composer install`
5. `php artisan migrate`
6. test with `php artisan test`
7. `php artisan serve`

#Manual testing
### Endpoints
1. GET api/currencies/conversions
2. GET api/currencies/list
3. GET api/currencies/queue
4. POST api/currencies/queue 
5. GET api/currencies/queue/result/{currencyReport}
6. GET api/currencies/timeframe
