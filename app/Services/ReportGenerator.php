<?php

namespace App\Services;

use App\Services\Interfaces\ReportGeneratorInterface;
use App\Repository\CurrencyConverterRepository;
use Illuminate\Support\Carbon;

abstract class ReportGenerator implements ReportGeneratorInterface
{
    protected string $currency;
    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }
    public function getReport(): array
    {
        $quotes = $this->getQuotes();
        return $this->parseData($quotes);
    }

    private function parseData(array $quotes): array
    {
        $currentInterval = $this->getInterval(Carbon::parse(array_key_first($quotes)));
        $totalForInterval = 0;
        $countInInterval = 0;
        foreach ($quotes as $date => $quote) {
            if ($currentInterval === $this->getInterval(Carbon::parse($date))) {
                $countInInterval++;
                $totalForInterval += $quote["USD" . $this->currency];
            } else {
                if ($countInInterval > 0) {
                    $output[] = $this->addToOutput($totalForInterval, $currentInterval, $countInInterval);
                }
                $currentInterval = $this->getInterval(Carbon::parse($date));
                $totalForInterval = $quote["USD" . $this->currency];
                $countInInterval = 1;
            }
        }
        if ($countInInterval > 0) {
            $output[] = $this->addToOutput($totalForInterval, $currentInterval, $countInInterval);
        }
        return $output;
    }

    private function addToOutput(float $totalForInterval, string $currentInterval, int $countInInterval): array
    {
        $out['average'] = $totalForInterval / $countInInterval;
        $out['date'] = $currentInterval;
        return $out;
    }

    /**
     * return an array of quotes used for the report
     */
    abstract protected function getQuotes(): array;
    /**
     * define how the interval should be recorded
     */
    abstract protected function getInterval(Carbon $date): string;
}
