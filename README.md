#Setup intructions
1. `cp .env.example .env`
2. Insert currencylayer api key into .env file `CURRENCY_LAYER_API_KEY` field in .env
3. Insert a admin password into the .env `ADMIN_PASSWORD` field
4. `composer install`
5. `php artisan migrate`
6. type "yes" when asked Would you like to create a sqlite database file
7. test with `php artisan test`
8. `php artisan serve` to launch server

#Manual testing
1. run `php artisan app:get-token` and copy the token printed to console
2. here is a sample Curl request:
```
curl -X GET \
  http://127.0.0.1:8000/api/currencies/conversions \
  -H 'Accept: application/json' \
  -H 'Authorization: Bearer {YOUR_TOKEN}' \
  -H 'Content-Type: application/json' \
```
### Endpoints
1. GET api/currencies/conversions
2. GET api/currencies/list
3. GET api/currencies/queue
4. POST api/currencies/queue 
    ###Body:
```
{
    report_uid: "SIX_MONTHS_ONE_WEEK",
    currency: EUR
    
 }
}
```
report_uid can be "SIX_MONTHS_ONE_WEEK" or "ONE_YEAR_ONE_MONTH" or "ONE_MONTH_ONE_DAY"
currency can be any abbreviated currency like EUR or CAD
5. GET api/currencies/queue/result/{currencyReport}
currencyReport is the ids from the currency_report table
7. POST  api/sign-up

