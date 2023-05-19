<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\Interfaces\ReportGeneratorInterface;
use App\Services\OneYearOneMonthReportGenerator;
use App\Models\CurrencyReport;
use App\Services\OneMonthOneDayReportGenerator;
use App\Services\SixMonthsOneWeekReportGenerator;

class ProcessReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected CurrencyReport $currencyReport)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $reportGenerator = $this->getReportGenerator($this->currencyReport->report_uid, $this->currencyReport->currency);
        $report = $reportGenerator->getReport();
        $this->currencyReport->result = $report;
        $this->currencyReport->save();
    }

    protected function getReportGenerator(string $uid, string $currency): ReportGeneratorInterface
    {
        if ($uid === "ONE_YEAR_ONE_MONTH") {
            return new OneYearOneMonthReportGenerator($currency);
        }
        if ($uid === "SIX_MONTHS_ONE_WEEK") {
            return new SixMonthsOneWeekReportGenerator($currency);
        }
        if ($uid === "ONE_MONTH_ONE_DAY") {
            return new OneMonthOneDayReportGenerator($currency);
        }
    }
}
