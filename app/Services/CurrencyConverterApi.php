<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Exception;
use App\Exceptions\CurrencyApiException;

class CurrencyConverterApi
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.apilayer.com/currency_data/',
            'headers' => [
                'apikey' => config('services.currency_layer_api_key')
            ]
        ]);
    }

    public function list(): array
    {
        $response = $this->client->request('GET', 'list');
        return json_decode($response->getBody(), true);
    }

    public function live() //: Collection
    {
        $response = $this->client->request('GET', 'live');
        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        }
    }

    public function timeframe(Carbon $startDate, Carbon $endDate, array $currencies)
    {
        $response = $this->client->request('GET', 'timeframe', [
            'query' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'currencies' => implode(',', $currencies)
            ]
        ]);
        if ($response->getStatusCode() !== 200) {
            throw new CurrencyApiException(
                "Currency Api failed with: " . (string)$response->getBody()
            );
        }
        return json_decode($response->getBody(), true);
    }
}
