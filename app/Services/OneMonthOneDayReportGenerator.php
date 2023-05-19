<?php

namespace App\Services;

use App\Services\Interfaces\ReportGeneratorInterface;
use App\Repository\CurrencyConverterRepository;
use Illuminate\Support\Carbon;
use App\Services\ReportGenerator;

class OneMonthOneDayReportGenerator extends ReportGenerator implements ReportGeneratorInterface
{

    protected function getInterval(Carbon $date): string
    {
        return $date->format('Y-m-d');
    }
    protected function getQuotes(): array
    {
        return (new CurrencyConverterRepository)->timeframe(Carbon::now()->subMonth(), Carbon::now(), [$this->currency]);
    }
}
