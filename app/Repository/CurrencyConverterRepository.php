<?php

namespace App\Repository;

use App\Services\CurrencyConverterApi;
use App\Models\Currency;
use Illuminate\Support\Carbon;

class CurrencyConverterRepository
{
    private $service;
    function __construct()
    {
        $this->service = new CurrencyConverterApi;
    }
    public function list(): array
    {
        return Currency::all()->toArray();
    }

    public function conversions(): array
    {
        $list = $this->service->live();
        return $list['quotes'];
    }

    public function timeframe(Carbon $startDate, Carbon $endDate, array $currencies): array
    {
        $timeframe = $this->service->timeframe($startDate, $endDate, $currencies);
        return $timeframe['quotes'];
    }
}
