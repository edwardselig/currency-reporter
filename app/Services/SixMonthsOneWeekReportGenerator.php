<?php

namespace App\Services;

use App\Services\Interfaces\ReportGeneratorInterface;
use App\Repository\CurrencyConverterRepository;
use Illuminate\Support\Carbon;
use App\Services\ReportGenerator;

class SixMonthsOneWeekReportGenerator extends ReportGenerator implements ReportGeneratorInterface
{

    protected function getInterval(Carbon $date): string
    {
        return $date->format('Y-W');
    }
    protected function getQuotes(): array
    {
        return (new CurrencyConverterRepository)->timeframe(Carbon::now()->subMonths(6), Carbon::now(), [$this->currency]);
    }
}
