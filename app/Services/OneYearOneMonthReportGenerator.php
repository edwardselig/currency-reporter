<?php

namespace App\Services;

use App\Services\Interfaces\ReportGeneratorInterface;
use App\Repository\CurrencyConverterRepository;
use Illuminate\Support\Carbon;

class OneYearOneMonthReportGenerator extends ReportGenerator implements ReportGeneratorInterface
{
    protected function getInterval(Carbon $date): string
    {
        return $date->format('Y-m');
    }
    protected function getQuotes(): array
    {
        return (new CurrencyConverterRepository)->timeframe(Carbon::now()->subYear(), Carbon::now(), [$this->currency]);
    }
}
